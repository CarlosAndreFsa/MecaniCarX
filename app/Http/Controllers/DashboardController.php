<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();
        $companyId = $user->company_id;
 
        $data =[
             'usersCount' => User::where('company_id', $companyId)
            ->count(),

        ];
        if($user->role  === 'admin'){
            $data['employeesCount'] = $user::where('company_id', $companyId)
            ->where('role', 'employee')
            ->count();

            $data['clientsCount'] = User::where('company_id', $companyId)
                ->where('role', 'client')
                ->count();

            $data['companyCount'] = Company::where('id', $companyId)
            ->count();

            return view('dashboards.admin', $data);
        }
        if ($user->role === 'employee') {
            return view('dashboards.employee', $data);
        }

        if ($user->role === 'client') {
            return view('dashboards.client', $data);
        }

        abort(403);
    }
}
