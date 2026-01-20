<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show(Request $request)
    {
        return view('company.show',[
            'company' =>$request->user()->company
        ]);
    }

    public function edit(Request $request)
    {
        $company = $request->user()->company;
        $this->authorize('update', $company);

        return view('company.update', compact('company'));
    }

    public function update(Request $request)
    {
        $company = $request->uer()->company();
        $this->authorize('update', $company);
        $data = $request->validate([
            'name' => 'required|string|mx:255',
            'cpf_cnpj' => 'nullable|string|max:20',

        ]);

        $company->update($data);

        return redirect()
        ->route('company.show')
        ->with('success', 'Empresa atualizada com sucesso!');

    }
    
    protected function authorizeUser(User $user)
    {
        abort_if(
            $user->company_id !== auth()->user()->company_id,
            403
        );
    }


}
