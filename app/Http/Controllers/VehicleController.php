<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        return view('vehicle.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicle.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'brand_id' => 'required|exists:brands,id',
            'model' => 'required|string|max:255',
            'plate' => 'required|string|max:20|unique:vehicles,plate',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:50',
            'vin' => 'nullable|string|max:17|unique:vehicles,vin',
        ]);

        Vehicle::create($data);

        return redirect()->route('vehicles.index')->with('success', 'Veículo criado com sucesso!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicle.show', compact('vehicle'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicle.edit', compact('vehicle'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'brand_id' => 'required|exists:brands,id',
            'model' => 'required|string|max:255',
            'plate' => 'required|string|max:20|unique:vehicles,plate,' .    $vehicle->id,
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:50',
            'vin' => 'nullable|string|max:17|unique:vehicles,vin,' . $vehicle->id,
        ]); 
        $vehicle->update($data);
        return redirect()->route('vehicles.index')->with('success', 'Veículo atualizado com sucesso!');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Veículo excluído com sucesso!');
    }
    /**
     * Generate a PDF for the specified resource.
     */
    // public function generatePdf(Vehicle $vehicle)
    // {
    //     $pdf = PDF::loadView('vehicle.pdf', compact('vehicle'));
    //     return $pdf->download('vehicle_' . $vehicle->id . '.pdf');
    // }    
    protected function authorizeUser(User $user)
    {
        abort_if(
            $user->company_id !== auth()->user()->company_id,
            403
        );
    }
    protected $casts = [
        'year' => 'integer',
    ];
   
}
