<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::where('company_id', $request->user()->company_id)->get();

         return view('customer.index', compact('customers'));

    }

    public function show(Customer $customer)
    {
      //  $customer = Customer::find($request->id);

        return view('customer.show', compact('customer'));
    }

    public function create()
    {
         return view('customer.create');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'name_fantasy' => 'nullable|string|max:255',
            'cpf_cnpj'     => 'nullable|string|max:20',
            'email'        => 'nullable|email',
            'phone'        => 'nullable|string|max:20',
            'website'      => 'nullable|string|max:50',
        
            'address.street'     => 'nullable|string|max:255',
            'address.number'     => 'nullable|string|max:20',
            'address.district'   => 'nullable|string|max:255',
            'address.city'       => 'nullable|string|max:255',
            'address.state'      => 'nullable|string|max:50',
            'address.zip_code'   => 'nullable|string|max:20',
            'address.complement' => 'nullable|string|max:255',
        ]);
        $company_id = Auth::user()->company_id;
     
        $customer = Customer::create([
            ...$data,
           
                'company_id' => $company_id,
                'active' => true,
          
        ]);
      
        // Atualiza ou cria endereço (se algum campo foi enviado)
        if (isset($data['address'])) {
            $customer->address()->updateOrCreate(
                [],
                $data['address']
            );
        }

        return redirect()
        ->route('customer.index')
        ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit(Customer $customer)
    {
       //   $customer = Customer::where('company_id', auth()->user()->company_id)->get();
          
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'name_fantasy' => 'nullable|string|max:255',
            'cpf_cnpj'     => 'nullable|string|max:20',
            'email'        => 'nullable|email',
            'phone'        => 'nullable|string|max:20',
        
            'address.street'     => 'nullable|string|max:255',
            'address.number'     => 'nullable|string|max:20',
            'address.district'   => 'nullable|string|max:255',
            'address.city'       => 'nullable|string|max:255',
            'address.state'      => 'nullable|string|max:50',
            'address.zip_code'   => 'nullable|string|max:20',
            'address.website'   => 'nullable|string|max:50',
            'address.complement' => 'nullable|string|max:255',
        ]);
  
        $customer->update($data);
        // Atualiza ou cria endereço (se algum campo foi enviado)
        if (isset($data['address'])) {
            $customer->address()->updateOrCreate(
                [],
                $data['address']
            );
        }
        return redirect()
        ->route('customer.index')
        ->with('success', 'Cliebte atualizada com sucesso!');
        
    }

    public function delete()
    {
        
    }
    public function active (Customer $customer)
    {
        $customer->update(['active' => ! $customer->active]);

        return back();

    }
    protected $casts = [
        'active' => 'boolean',
        ];

    public function search(Request $request)
    {
        $term = $request->get('q');

        // Busca rápida apenas na empresa do usuário logado
        $customers = Customer::where('company_id', auth()->user()->company_id)
            ->where('name', 'LIKE', "%{$term}%")
            ->select('id', 'name')
            ->orderBy('name')
            ->limit(15) // Velocidade: nunca carregue mais que o necessário
            ->get();

        return response()->json($customers);
    }
}
