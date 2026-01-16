<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('company_id', $request->user()->company_id)
            ->where('role', '!=', 'client')
            ->get();

            return view('users.index', compact('users'));

    }

     public function create()
     {
        return view('users.create');

     }

     public function store(Request $request)
    {
       
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

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
       
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
      
         $this->authorizeUser($user);

        $user->update(['active' => ! $user->active]);

        return back();
    }

    protected function authorizeUser(User $user)
    {
        abort_if(
            $user->company_id !== auth()->user()->company_id,
            403
        );
    }
    protected $casts = [
        'active' => 'boolean',
        ];

}
