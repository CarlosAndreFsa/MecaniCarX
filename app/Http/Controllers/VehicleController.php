<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companyId = auth()->user()->company_id;
        
        // Traz os relacionamentos para evitar queries N+1
        $query = Vehicle::with(['customer', 'brand'])->where('company_id', $companyId);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('plate', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%')
                  ->orWhere('id', $request->search);
            });
        }

        $vehicles = $query->latest()->paginate(10)->withQueryString();

        return view('vehicle.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companyId = auth()->user()->company_id;
        
        $customers = Customer::where('company_id', $companyId)->orderBy('name')->get();
        $brands = Brand::orderBy('name')->get(); // Marcas são globais

        return view('vehicle.create', compact('customers', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $data = $request->validate([
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where(function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                }),
            ],
            'brand_id' => 'required|exists:brands,id',
            'model' => 'required|string|max:255',
            'plate' => [
                'required',
                'string',
                'max:20',
                // Placa deve ser única dentro da empresa
                Rule::unique('vehicles')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                }),
            ],
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
        ]);

        $data['company_id'] = $companyId;

        Vehicle::create($data);

        return redirect()->route('vehicles.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        if ($vehicle->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $vehicle->load(['customer', 'brand']);

        return view('vehicle.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        if ($vehicle->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $companyId = auth()->user()->company_id;
        $customers = Customer::where('company_id', $companyId)->orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('vehicle.edit', compact('vehicle', 'customers', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $companyId = auth()->user()->company_id;

        $data = $request->validate([
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where(function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                }),
            ],
            'brand_id' => 'required|exists:brands,id',
            'model' => 'required|string|max:255',
            'plate' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehicles')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                })->ignore($vehicle->id),
            ],
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
        ]);

        $vehicle->update($data);

        return redirect()->route('vehicles.index')->with('edit', 'Veículo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Aqui você pode adicionar verificação se o veículo possui Ordens de Serviço (OS) antes de deletar
        if ($vehicle->serviceOrders()->exists()) {
             return redirect()->route('vehicles.index')->with('error', 'Não é possível excluir este veículo pois ele possui ordens de serviço vinculadas.');
        }

        $vehicle->delete();

        return redirect()->route('vehicle.index')->with('delete', 'Veículo removido com sucesso!');
    }
}
