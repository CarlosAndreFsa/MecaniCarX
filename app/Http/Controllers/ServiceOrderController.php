<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ServiceOrder::query()->with(['customer', 'vehicle'])->where('company_id', $request->user()->company_id);

        // Filtro de busca (Número ou Nome do Cliente)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhereRelation('vehicle', 'plate', 'like', "%{$search}%")
                    ->orWhere('customer_id', $search) // Busca exata por ID do cliente
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filtro de Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('serviceOrder.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        return view('serviceOrder.create', compact('customers'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $companyId = $request->user()->company_id;

        $data = $request->validate([
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where('company_id', $companyId),
            ],
            'vehicle_id' => [
                'required',
                Rule::exists('vehicles', 'id')->where('company_id', $companyId),
            ],
            'title' => 'required|string|max:255',
            'technical_description' => 'nullable|string',
            'customer_description' => 'required|string',
            'labor_cost' => 'nullable|numeric',
            'parts_cost' => 'nullable|numeric',
            'entry_date' => 'required|date',
            'delivery_date' => 'nullable|date',
        ]);
        $data['labor_cost'] = floatval($data['labor_cost'] ?? 0);
        $data['parts_cost'] = floatval($data['parts_cost'] ?? 0);
        $data['number'] = 'OS-' . now()->timestamp;
        $data['total'] = ($data['labor_cost'] ?? 0) + ($data['parts_cost'] ?? 0);
        $data['company_id'] = $companyId;

        ServiceOrder::create($data);

        return redirect()
            ->route('service-orders.index')
            ->with('success', 'Ordem de serviço criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceOrder $service_order)
    {
        if ($service_order->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $service_order->load(['customer', 'vehicle']);

        return view('serviceOrder.show', compact('service_order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceOrder $service_order)
    {
        if ($service_order->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        return view('serviceOrder.edit', compact('service_order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceOrder $service_order)
    {
        if ($service_order->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $companyId = $request->user()->company_id;

        $data = $request->validate([
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where('company_id', $companyId),
            ],
            'vehicle_id' => [
                'required',
                Rule::exists('vehicles', 'id')->where('company_id', $companyId),
            ],
            'title' => 'required|string|max:255',
            'customer_description'   => 'required|string',
            'technical_description'   => 'nullable|string',
            'labor_cost'    => 'nullable|numeric',
            'parts_cost'    => 'nullable|numeric',
            'entry_date'    => 'required|date',
            'delivery_date' => 'nullable|date',
            'status'        => 'required|string',
        ]);
        $data['labor_cost'] = floatval($data['labor_cost'] ?? 0);
        $data['parts_cost'] = floatval($data['parts_cost'] ?? 0);
        $data['total'] = ($data['labor_cost'] ?? 0) + ($data['parts_cost'] ?? 0);

        $service_order->update($data);

        return redirect()
            ->route('service-orders.index')
            ->with('edit', 'Ordem de serviço atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceOrder $service_order)
    {
        if ($service_order->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // 1. Opcional: Verificar se a OS pode ser excluída (ex: não excluir se estiver 'concluída')
        if ($service_order->status === 'completed') {
            return redirect()->back()->with('error', 'Não é possível excluir uma ordem concluída.');
        }

        // 2. Deletar do banco
        $service_order->delete();

        // 3. Redirecionar com mensagem de sucesso
        return redirect()->route('service-orders.index')
            ->with('delete', 'Ordem de serviço removida com sucesso!');
    }
    public function generatePdf(ServiceOrder $service_order)
{
    if ($service_order->company_id !== auth()->user()->company_id) {
        abort(403);
    }

    // Busca a logo e converte para Base64 (Obrigatório para PDF)
    $logoPath = public_path('/assets/img/logo-mecanicarx.png'); 
    $logoBase64 = null;
    if (file_exists($logoPath)) {
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoBase64 = 'data:image/png;base64,' . $logoData;
    }

    // Para o PDF (Download/Stream)
    $html = view('serviceOrder.pdf', compact('service_order', 'logoBase64'))->render();
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

    return \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
        ->setPaper('a4', 'portrait')
        ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        ->stream("OS-{$service_order->number}.pdf");
}

public function print(ServiceOrder $service_order)
{
    if ($service_order->company_id !== auth()->user()->company_id) abort(403);

    // Mesma lógica da logo para a impressão do navegador
    $logoPath = public_path('/assets/img/logo-mecanicarx.png'); 
  
    $logoBase64 = null;
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }

    return view('serviceOrder.print', compact('service_order', 'logoBase64'));
}
}
