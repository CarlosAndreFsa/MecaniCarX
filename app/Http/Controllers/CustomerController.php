<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Inicia a query garantindo que o usuário só veja clientes da sua própria empresa
        $query = Customer::query()->where('company_id', $request->user()->company_id);

        // Filtro de Busca (Nome, Email, Telefone ou Documento)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_fantasy', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('cpf_cnpj', 'like', "%{$search}%");
            });
        }

        // Filtro de Status (Ativo / Inativo)
        if ($request->status === '0' || $request->status === '1') {
            $query->where('active', $request->status);
        }

        // Ordena pelos mais recentes, pagina (ex: 10 por página) e mantém a querystring na paginação
        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('customer.index', compact('customers'));
    }


    public function show(Customer $customer)
    {
        if ($customer->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

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
        if ($customer->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }
          
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if ($customer->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

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
        ->with('success', 'Cliente atualizado com sucesso!');
        
    }

    public function destroy(Customer $customer)
    {
         if ($customer->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $vehicleCount = $customer->vehicles()->count();

        if ($vehicleCount > 0) {
            $url = route('vehicles.index', ['search' => $customer->name]);
            return redirect()->route('customer.index')
                ->with('error', 'Não é possível excluir este cliente, pois ele possui <a href="' . $url . '" class="underline font-black hover:text-red-900">' . $vehicleCount . ' veículo(s)</a> vinculado(s).');
        }

        $customer->delete();

        return redirect()->route('customer.index')
            ->with('delete', 'Cliente removido com sucesso!');
    }
    
    public function active (Customer $customer)
    {
        if ($customer->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $customer->update(['active' => ! $customer->active]);

        return back();

    }
    protected $casts = [
        'active' => 'boolean',
        ];

    public function search(Request $request)
    {
        $term = $request->get('qsearch');

        // Busca rápida apenas na empresa do usuário logado
        $customers = Customer::where('company_id', auth()->user()->company_id)
            ->where('name', 'LIKE', "%{$term}%")
            ->select('id', 'name')
            ->orderBy('name')
            ->limit(15) // Velocidade: nunca carregue mais que o necessário
            ->get();

        return response()->json($customers);
    }

    public function getVehicles(Customer $customer)
    {
        // Medida de segurança: Garante que o cliente pertence à empresa do usuário logado
        if ($customer->company_id !== auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Retorna apenas os veículos pertencentes a esse cliente
        return response()->json($customer->vehicles()->select(['id', 'plate', 'model'])->get());
    }

}
