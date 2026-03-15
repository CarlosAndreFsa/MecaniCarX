<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;
    
    #[Test]
    public function an_authenticated_admin_can_create_a_vehicle()
    {
        // 1. Arrange (Preparação)
        // Criamos os dados necessários: uma empresa, um usuário admin, um cliente e uma marca.
        // Usamos Factories para gerar dados falsos de forma consistente.
        $company = Company::factory()->create();
        $user = User::factory()->for($company)->create(['role' => 'admin']);
        $customer = Customer::factory()->for($company)->create();
        $brand = Brand::factory()->create();

        // Simula que o usuário está logado no sistema
        $this->actingAs($user);

        // Dados do veículo que serão enviados no formulário
        $vehicleData = [
            'customer_id' => $customer->id,
            'brand_id' => $brand->id,
            'model' => 'Gol',
            'plate' => 'ABC-1234',
            'year' => 2020,
            'color' => 'Branco',
        ];

        // 2. Act (Ação)
        // Fazemos uma requisição POST para a rota que (ainda não existe) salvará o veículo.
        $response = $this->post(route('vehicles.store'), $vehicleData);

        // 3. Assert (Verificação)
        // Verificamos se o veículo foi realmente salvo no banco de dados com a placa correta
        // e se pertence à empresa do usuário logado.
        $this->assertDatabaseHas('vehicles', [
            'plate' => 'ABC-1234',
            'company_id' => $company->id,
        ]);

        // Verificamos se o usuário foi redirecionado para a página de listagem de veículos
        $response->assertRedirect(route('vehicles.index'));
    }
}
