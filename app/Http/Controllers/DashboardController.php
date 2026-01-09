<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user->role){
            'admin' => view('dashboards.admin'),
            'employee' => view('dashboards.employee'),
            'client' => view('dashboards.client'),
            default  => abort(403),        
        };
    }
}
