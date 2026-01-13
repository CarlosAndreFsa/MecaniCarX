<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('company_id', $request->user()->company_id)
            ->where('role', '!=', 'client')
            ->get();
dd($users);
            return view('users.index', compact('users'));

    }
}
