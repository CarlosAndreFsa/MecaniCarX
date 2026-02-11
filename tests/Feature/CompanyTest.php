<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PhpParser\Node\Expr\FuncCall;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    protected function createUserWithCompany(): User
    {
        $company = Company::factory()->create();

        return User::factory()->create([
            'company_id' => $company->id,
            'role'  =>  'admin',
            'active'    => true,
        ]);
    }

   public function test_user_can_view_company()
   {
        $user = $this->createUserWithCompany();
        $response = $this->actingAs($user)
        ->get(route('company.show'));

        $response->assertStatus(200);
        $response->assertSee($user->company->name);
   }

   public function test_user_can_update_own_company()
   {
        $user = $this->createUserWithCompany();

        $response = $this->actingAs($user)
        ->put(route('company.update',[
            'name'  => 'Empresa atualizada',
            'cpf_cnpj' =>   '12345678910',
        ]));

        $response->assertRedirect(route('company.show'));

        $this->assertDatabaseHas('companies', [
            'id'    =>   $user->company_id,
            'name' => 'Empresa atualizada',
        ]);
    }

    
    public function test_company_name_is_required()
    {
        $user = $this->createUserWithCompany();

        $response = $this->actingAs($user)
            ->put(route('company.update'), [
                'name' => '',
            ]);

        $response->assertSessionHasErrors('name');
    }


}
