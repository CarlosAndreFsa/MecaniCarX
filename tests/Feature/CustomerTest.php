<?php

namespace Tests\Feature;

use App\Mail\ClientAccessCredentials;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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
    public function creating_a_customer_creates_and_displays_temporary_client_credentials_by_default()
    {
        Mail::fake();

        $company = Company::factory()->create();
        $user = User::factory()->for($company)->create(['role' => 'admin', 'active' => true]);
        $this->actingAs($user);

        $formResponse = $this->get(route('customer.create'));
        $formResponse->assertSee('id="create-user" name="create_user" value="1" checked', false);

        $this->post(route('customer.store'), [
            'name' => 'Cliente com Acesso',
            'name_fantasy' => 'Cliente Acesso',
            'email' => 'cliente-acesso@example.com',
            'create_user' => '1',
        ])->assertRedirect(route('customer.index'))
            ->assertSessionHas('temporary_password');

        $temporaryPassword = session('temporary_password');
        Mail::assertSent(ClientAccessCredentials::class, function (ClientAccessCredentials $mail) use ($temporaryPassword) {
            return $mail->customer->email === 'cliente-acesso@example.com'
                && $mail->temporaryPassword === $temporaryPassword;
        });

        $this->get(route('customer.index'))
            ->assertOk()
            ->assertSee('Senha temporária:')
            ->assertSee($temporaryPassword);
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
