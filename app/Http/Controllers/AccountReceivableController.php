<?php

namespace App\Http\Controllers;

use App\Models\AccountReceivable;
use App\Models\Customer;
use App\Models\ReceivableInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AccountReceivableController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountReceivable::query()
            ->with(['customer', 'serviceOrder', 'installments'])
            ->where('accounts_receivable.company_id', $request->user()->company_id);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->integer('customer_id'));
        }

        if ($request->filled('from')) {
            $query->whereHas('installments', fn ($q) => $q->whereDate('due_date', '>=', $request->date('from')));
        }

        if ($request->filled('to')) {
            $query->whereHas('installments', fn ($q) => $q->whereDate('due_date', '<=', $request->date('to')));
        }

        if ($request->filled('service_order')) {
            $search = $request->service_order;
            $query->whereHas('serviceOrder', fn ($q) => $q->where('number', 'like', "%{$search}%"));
        }

        $query->withMin('installments', 'due_date')
            ->orderByRaw('COALESCE((SELECT MIN(due_date) FROM receivable_installments WHERE receivable_installments.account_receivable_id = accounts_receivable.id), issue_date) ASC');

        $accounts = $query->paginate(15)->withQueryString();
        $customers = Customer::where('company_id', $request->user()->company_id)
            ->where('active', true)
            ->orderBy('name')
            ->get();
        $groupBy = $request->string('group_by')->toString();

        $groups = null;
        if (in_array($groupBy, ['customer', 'service_order', 'due_date'], true)) {
            $allAccounts = (clone $query)->get();
            $groups = match ($groupBy) {
                'customer' => $allAccounts->groupBy(fn ($account) => $account->customer->name),
                'service_order' => $allAccounts->groupBy(fn ($account) => $account->serviceOrder
                    ? 'OS #' . $account->serviceOrder->number
                    : 'Cadastro direto'),
                'due_date' => $allAccounts->groupBy(fn ($account) => $account->installments
                    ->min('due_date')?->format('Y-m-d') ?? $account->issue_date->format('Y-m-d')),
            };
        }

        return view('financial.accounts-receivable.index', compact('accounts', 'customers', 'groups', 'groupBy'));
    }

    private function filteredAccounts(Request $request)
    {
        $query = AccountReceivable::query()
            ->with(['customer', 'serviceOrder', 'installments'])
            ->where('company_id', $request->user()->company_id);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('search')) {
            $query->whereHas('customer', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->integer('customer_id'));
        }
        if ($request->filled('from')) {
            $query->whereHas('installments', fn ($q) => $q->whereDate('due_date', '>=', $request->date('from')));
        }
        if ($request->filled('to')) {
            $query->whereHas('installments', fn ($q) => $q->whereDate('due_date', '<=', $request->date('to')));
        }
        if ($request->filled('service_order')) {
            $query->whereHas('serviceOrder', fn ($q) => $q->where('number', 'like', '%' . $request->service_order . '%'));
        }

        return $query
            ->orderByRaw('COALESCE((SELECT MIN(due_date) FROM receivable_installments WHERE receivable_installments.account_receivable_id = accounts_receivable.id), issue_date) ASC')
            ->get();
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $accounts = $this->filteredAccounts($request);

        return response()->streamDownload(function () use ($accounts) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, ['Conta', 'Cliente', 'OS', 'Descricao', 'Emissao', 'Vencimento', 'Valor', 'Recebido', 'Status']);

            foreach ($accounts as $account) {
                foreach ($account->installments as $installment) {
                    fputcsv($output, [
                        $account->id,
                        $account->customer->name,
                        $account->serviceOrder?->number ?? '',
                        $account->description,
                        $account->issue_date->format('d/m/Y'),
                        $installment->due_date->format('d/m/Y'),
                        number_format($installment->amount, 2, ',', '.'),
                        number_format($installment->received_amount, 2, ',', '.'),
                        $installment->status,
                    ]);
                }
            }
            fclose($output);
        }, 'contas-a-receber.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $accounts = $this->filteredAccounts($request);
        $html = view('financial.accounts-receivable.report', [
            'accounts' => $accounts,
            'title' => 'Relatório de Contas a Receber',
        ])->render();

        return Pdf::loadHTML($html)->setPaper('a4', 'portrait')
            ->stream('contas-a-receber.pdf');
    }

    public function print(Request $request)
    {
        $accounts = $this->filteredAccounts($request);
        $format = $request->string('format')->toString() === 'thermal' ? 'thermal' : 'a4';

        return view('financial.accounts-receivable.report-print', compact('accounts', 'format'));
    }

    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'subject' => 'nullable|string|max:150',
            'message' => 'nullable|string|max:2000',
            'filters' => 'nullable|array',
        ]);

        $accounts = $this->filteredAccounts($request->merge($data['filters'] ?? []));
        $pdf = Pdf::loadHTML(view('financial.accounts-receivable.report', [
            'accounts' => $accounts,
            'title' => 'Relatório de Contas a Receber',
        ])->render())->output();

        Mail::raw($data['message'] ?: 'Segue anexo o relatório de contas a receber.', function ($mail) use ($data, $pdf) {
            $mail->to($data['email'])
                ->subject($data['subject'] ?: 'Relatório de Contas a Receber')
                ->attachData($pdf, 'contas-a-receber.pdf', ['mime' => 'application/pdf']);
        });

        return back()->with('success', 'Relatório enviado por e-mail.');
    }

    public function create(Request $request)
    {
        $customers = Customer::where('company_id', $request->user()->company_id)
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('financial.accounts-receivable.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $companyId = $request->user()->company_id;

        $data = $request->validate([
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where('company_id', $companyId),
            ],
            'description' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'total' => 'required|numeric|min:0.01',
            'installments_count' => 'required|integer|min:1|max:60',
            'first_due_date' => 'required|date',
            'immediate_payment' => 'nullable|boolean',
            'payment_method' => 'nullable|required_if:immediate_payment,1|in:cash,pix,card',
            'notes' => 'nullable|string',
        ]);

        $account = DB::transaction(function () use ($data, $companyId) {
            $account = AccountReceivable::create([
                'company_id' => $companyId,
                'customer_id' => $data['customer_id'],
                'description' => $data['description'],
                'issue_date' => $data['issue_date'],
                'total' => $data['total'],
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            $count = (bool) ($data['immediate_payment'] ?? false)
                ? 1
                : (int) $data['installments_count'];

            $this->createInstallments(
                $account,
                $count,
                $data['first_due_date'],
                (float) $data['total'],
                (bool) ($data['immediate_payment'] ?? false),
                $data['payment_method'] ?? null
            );

            $account->refreshStatus();
            return $account;
        });

        return redirect()
            ->route('accounts-receivable.show', $account)
            ->with('success', 'Conta a receber criada com sucesso.');
    }

    public function show(Request $request, AccountReceivable $accounts_receivable)
    {
        if ($accounts_receivable->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $accounts_receivable->load(['customer', 'serviceOrder', 'installments']);

        return view('financial.accounts-receivable.show', [
            'account' => $accounts_receivable,
        ]);
    }

    public function receive(Request $request, ReceivableInstallment $installment)
    {
        $account = $installment->accountReceivable;

        if ($account->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'received_amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,pix,card',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $remaining = (float) $installment->amount - (float) $installment->received_amount;

        if ((float) $data['received_amount'] > $remaining) {
            return back()->withErrors([
                'received_amount' => "O valor recebido não pode exceder R$ " . number_format($remaining, 2, ',', '.'),
            ]);
        }

        DB::transaction(function () use ($installment, $account, $data, $remaining) {
            $received = (float) $installment->received_amount + (float) $data['received_amount'];
            $installment->update([
                'received_amount' => $received,
                'status' => $received >= (float) $installment->amount ? 'paid' : 'pending',
                'payment_method' => $data['payment_method'],
                'paid_at' => $data['paid_at'] ?? now(),
                'notes' => $data['notes'] ?? $installment->notes,
            ]);

            $account->refreshStatus();
        });

        return back()->with('success', 'Recebimento registrado com sucesso.');
    }

    public function cancel(Request $request, AccountReceivable $accounts_receivable)
    {
        if ($accounts_receivable->company_id !== $request->user()->company_id) {
            abort(403);
        }

        if ($accounts_receivable->status === 'paid') {
            return back()->withErrors(['account' => 'Não é possível cancelar uma conta já recebida.']);
        }

        DB::transaction(function () use ($accounts_receivable) {
            $accounts_receivable->update(['status' => 'canceled']);
            $accounts_receivable->installments()->update([
                'status' => 'canceled',
                'received_amount' => 0,
                'paid_at' => null,
            ]);
        });

        return back()->with('success', 'Conta a receber cancelada.');
    }

    public function createInstallments(
        AccountReceivable $account,
        int $count,
        string $firstDueDate,
        float $total,
        bool $immediate = false,
        ?string $paymentMethod = null
    ): void {
        $firstDue = \Carbon\Carbon::parse($firstDueDate);
        $centavos = (int) round($total * 100);
        $base = intdiv($centavos, $count);
        $resto = $centavos % $count;

        for ($number = 1; $number <= $count; $number++) {
            $amountCentavos = $base + ($number <= $resto ? 1 : 0);
            $dueDate = $number === 1
                ? $firstDue->copy()
                : $firstDue->copy()->addMonthsNoOverflow($number - 1);

            $account->installments()->create([
                'number' => $number,
                'due_date' => $dueDate->toDateString(),
                'amount' => $amountCentavos / 100,
                'received_amount' => $immediate ? $amountCentavos / 100 : 0,
                'status' => $immediate ? 'paid' : 'pending',
                'payment_method' => $immediate ? $paymentMethod : null,
                'paid_at' => $immediate ? now() : null,
            ]);
        }
    }
}
