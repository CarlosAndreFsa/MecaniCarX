<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();
        $companyId = $user->company_id;
 
        return match ($user->role){
            'admin' => view('dashboards.admin', [
                'employeesCount' => User::where('company_id', $companyId)
                ->where('role', 'employee')
                ->count(),
            ]),

            'clientsCount' => User::where('company_id', $companyId)
            ->where('role', 'client')
            ->count(),

            'usersCount' => User::where('company_id', $companyId)
            ->count(),

            'employee' => view('dashboards.employee'),
            'client' => view('dashboards.client'),

            default  => abort(403),        
        };
    }
}
