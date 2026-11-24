<?php

namespace App\Http\Controllers;

use App\Models\AccountReceivable;
use App\Models\Customer;
use App\Models\ReceivableInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AccountReceivableController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountReceivable::query()
            ->with(['customer', 'serviceOrder', 'installments'])
            ->where('company_id', $request->user()->company_id);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $accounts = $query->latest()->paginate(15)->withQueryString();

        return view('financial.accounts-receivable.index', compact('accounts'));
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
