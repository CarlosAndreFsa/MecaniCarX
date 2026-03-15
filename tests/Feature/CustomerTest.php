<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function an_authenticated_user_can_view_customers_list()
    {
        $company = Company::factory()->create();
        $user = User::factory()->for($company)->create(['role' => 'admin', 'active' => true]);

        $this->actingAs($user);

        Customer::factory()->for($company)->create([
            'name' => 'Cliente Teste Visualização'
        ]);        
        
        $this->assertDatabaseHas('customers', [
            'name' => 'Cliente Teste Visualização',
            'company_id' => $company->id,
        ]);
        

        $response = $this->get(route('customer.index'));

        $response->assertStatus(200);
        $response->assertSee('Cliente Teste Visualização');
    }

    #[Test]
    public function an_authenticated_user_can_create_a_customer()
    {
        $company = Company::factory()->create();
        $user = User::factory()->for($company)->create(['role' => 'admin', 'active' => true]);

        $this->actingAs($user);

        $customerData = [
            'name' => 'João da Silva',
            'name_fantasy' => 'Oficina do João',
            'cpf_cnpj' => '12345678901',
            'email' => 'joao@example.com',
            'phone' => '11999999999',
        ];

        $response = $this->post(route('customer.store'), $customerData);

        $this->assertDatabaseHas('customers', [
            'name' => 'João da Silva',
            'company_id' => $company->id,
            'active' => 1, // Por padrão, o controller cria como true
        ]);

        $response->assertRedirect(route('customer.index'));
    }

    #[Test]
    public function an_authenticated_user_can_update_a_customer()
    {
        $company = Company::factory()->create();
        $user = User::factory()->for($company)->create(['role' => 'admin', 'active' => true]);

        $this->actingAs($user);

        $customer = Customer::factory()->for($company)->create([
            'name' => 'Nome Antigo'
        ]);

        $updateData = [
            'name' => 'Nome Atualizado',
            'email' => 'novoemail@example.com',
        ];

        $response = $this->put(route('customer.update', $customer), $updateData);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Nome Atualizado',
            'email' => 'novoemail@example.com',
        ]);
    }

    #[Test]
    public function an_authenticated_user_can_toggle_customer_status()
    {
        $company = Company::factory()->create();
        $user = User::factory()->for($company)->create(['role' => 'admin', 'active' => true]);

        $this->actingAs($user);

        $customer = Customer::factory()->for($company)->create(['active' => true]);
        $response = $this->patch(route('customer.active', $customer));

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'active' => 0, // Inativou
        ]);
    }
}
