<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Mail\ClientAccessCredentials;

class CustomerController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode acessar cadastros de clientes.');
        }

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
        if (auth()->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode acessar cadastros de clientes.');
        }

      //  $customer = Customer::find($request->id);

        return view('customer.show', compact('customer'));
    }

    public function create()
    {
        if (auth()->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode cadastrar clientes.');
        }

         return view('customer.create');
    }

    public function store(Request $request)
    {
        if ($request->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode cadastrar clientes.');
        }

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'name_fantasy' => 'nullable|string|max:255',
            'cpf_cnpj'     => 'nullable|string|max:20|unique:customers,cpf_cnpj',
            'email'        => 'nullable|email|unique:customers,email',
            'phone'        => 'nullable|string|max:20',
            'website'      => 'nullable|string|max:50',
        
            'address.street'     => 'nullable|string|max:255',
            'address.number'     => 'nullable|string|max:20',
            'address.district'   => 'nullable|string|max:255',
            'address.city'       => 'nullable|string|max:255',
            'address.state'      => 'nullable|string|max:50',
            'address.zip_code'   => 'nullable|string|max:20',
            'address.complement' => 'nullable|string|max:255',
            'create_user' => 'nullable|boolean',
        ]);
        
        if ($request->boolean('create_user')) {
            $request->validate([
                'email' => 'required|email|unique:users,email',
            ]);
        }

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

        if ($request->boolean('create_user')) {
            $temporaryPassword = Str::random(12);

            $clientUser = User::create([
                'name' => $customer->name,
                'email' => $customer->email,
                'password' => Hash::make($temporaryPassword),
                'company_id' => $company_id,
                'customer_id' => $customer->id,
                'role' => 'client',
                'active' => true,
                'password_must_be_changed' => true,
            ]);

            $accessUrl = URL::temporarySignedRoute(
                'password.temporary-access',
                now()->addDay(),
                ['user' => $clientUser->id]
            );

            Mail::to($customer->email)->send(
                new ClientAccessCredentials(
                    $customer,
                    $temporaryPassword,
                    $accessUrl
                )
            );

            return redirect()
                ->route('customer.index')
                ->with('success', 'Cliente cadastrado e usuário de acesso criado!')
                ->with('temporary_email', $customer->email)
                ->with('temporary_password', $temporaryPassword);
        }

        return redirect()
        ->route('customer.index')
        ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit(Customer $customer)
    {
        if (auth()->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode editar clientes.');
        }

       //   $customer = Customer::where('company_id', auth()->user()->company_id)->get();
          
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if ($request->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode editar clientes.');
        }

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'name_fantasy' => 'nullable|string|max:255',
            'cpf_cnpj'     => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('customers', 'cpf_cnpj')->ignore($customer->id),
            ],
            'email'        => [
                'nullable',
                'email',
                Rule::unique('customers', 'email')->ignore($customer->id),
            ],
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
        if (auth()->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode alterar clientes.');
        }

        $customer->update(['active' => ! $customer->active]);

        return back();

    }
    protected $casts = [
        'active' => 'boolean',
        ];

    public function search(Request $request)
    {
        if ($request->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode pesquisar clientes.');
        }

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

        if (auth()->user()->role === 'client'
            && $customer->id !== auth()->user()->customer_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Retorna apenas os veículos pertencentes a esse cliente
        return response()->json($customer->vehicles()->select(['id', 'plate', 'model'])->get());
    }

}
