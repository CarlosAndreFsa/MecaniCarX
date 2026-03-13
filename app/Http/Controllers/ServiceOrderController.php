<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = ServiceOrder::with('customer')
        ->where('company_id', auth()->user()->company_id)
        ->latest()->paginate(10);

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
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
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
        $order = ServiceOrder::find($service_order);

        return view('serviceOrder.show', compact('service_order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceOrder $service_order)
    {
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        return view('serviceOrder.edit',compact('service_order','customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceOrder $service_order)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
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
        $data['number'] = 'OS-' . now()->timestamp;
        $data['total'] = ($data['labor_cost'] ?? 0) + ($data['parts_cost'] ?? 0);

        $service_order->update($data);

        return redirect()
            ->route('service-orders.index')
            ->with('success', 'Ordem de serviço criada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(ServiceOrder $service_order)
{
    // 1. Opcional: Verificar se a OS pode ser excluída (ex: não excluir se estiver 'concluída')
    if ($service_order->status === 'completed') {
        return redirect()->back()->with('error', 'Não é possível excluir uma ordem concluída.');
    }

    // 2. Deletar do banco
    $service_order->delete();

    // 3. Redirecionar com mensagem de sucesso
    return redirect()->route('service-orders.index')
                     ->with('success', 'Ordem de serviço removida com sucesso!');
}
}
