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
            'role' => 'required|in:admin,employee',
        ]);

        User::create([
            ...$data,
            'company_id' => $request->user()->company_id,
            'password' => Hash::make('password'),
            'active' => true,
        ]);

        return redirect()->route('users.index');
    }

}
