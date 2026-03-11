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
            'description' => 'nullable|string',
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
            ->route('serviceOrder.index')
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
        $customers = Customer::all();
        return view('serviceOrder.edit',compact('service_order','customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceOrder $serviceOrder)
    {
        //
    }
}
