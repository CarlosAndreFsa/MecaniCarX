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

        return view('company.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $company = $request->user()->company;
      
        //$this->authorize('update', $company);
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'name_fantasy' => 'nullable|string|max:255',
            'cpf_cnpj'     => 'nullable|string|max:20',
            'email'        => 'nullable|email',
            'phone'        => 'nullable|string|max:20',
            'website'      => 'nullable|string|max:255',
            'logo'         => 'nullable|string',

            'address.street'     => 'nullable|string|max:255',
            'address.number'     => 'nullable|string|max:20',
            'address.district'   => 'nullable|string|max:255',
            'address.city'       => 'nullable|string|max:255',
            'address.state'      => 'nullable|string|max:50',
            'address.zip_code'   => 'nullable|string|max:20',
            'address.complement' => 'nullable|string|max:255',
        ]);
  
        $company->update($data);
        // Atualiza ou cria endereço (se algum campo foi enviado)
        if (isset($data['address'])) {
            $company->address()->updateOrCreate(
                [],
                $data['address']
            );
        }
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
