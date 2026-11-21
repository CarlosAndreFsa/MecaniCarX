<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode acessar usuários.');
        }

        $query = User::query()
            ->where('company_id', $request->user()->company_id);
            //->where('role', '!=', 'client');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && ($request->status === '0' || $request->status === '1')) {
            $query->where('active', $request->status);
        } elseif (! $request->has('status')) {
            $query->where('active', true);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('users.index', compact('users'));

    }

     public function create()
     {
        if (auth()->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode cadastrar usuários.');
        }

        return view('users.create');

     }

     public function store(Request $request)
    {
         if ($request->user()->role === 'client') {
             abort(403, 'Usuário cliente não pode cadastrar usuários.');
         }
       
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,employee,client',
        ]);

        User::create([
            ...$data,
            'company_id' => $request->user()->company_id,
            'password' => Hash::make('password'),
            'active' => true,

        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode editar usuários.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($request->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode editar usuários.');
        }
       
        $data = $request->validate([
            'name' => ['required', 'string'],
            'role' => ['required', 'in:admin,employee'],
            'active' => ['required', 'boolean'],
        ]);

        $user->update($data);

        return redirect()->route('users.index');
    }

    public function active(User $user)
    {
        if (auth()->user()->role === 'client') {
            abort(403, 'Usuário cliente não pode alterar usuários.');
        }
      
         $this->authorizeUser($user);
        $user->update(['active' => ! $user->active]);

        return back();
    }

    protected function authorizeUser(User $user)
    {
        abort_if(
            $user->company_id !== auth()->user()->company_id, //->user()->company_id,
            403
        );
    }
    protected $casts = [
        'active' => 'boolean',
        ];

}
