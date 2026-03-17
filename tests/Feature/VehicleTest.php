<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vehicle;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Concerns\AssertsStatusCodes;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;     
   
    protected $company;
    protected $user;
    protected $customer;
    protected $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create();
        $this->user = User::factory()->for($this->company)->create(['role' => 'admin', 'active' => true]);
        $this->customer = Customer::factory()->for($this->company)->create();
        $this->brand = Brand::factory()->create();
    }

    #[Test]
    public function an_authenticated_admin_can_create_a_vehicle()
    {
        // Simula que o usuário está logado no sistema
        $this->actingAs($this->user);

        // Dados do veículo que serão enviados no formulário
        $vehicleData = [
            'customer_id' => $this->customer->id,
            'brand_id' => $this->brand->id,
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
            'company_id' => $this->company->id,
        ]);

        // Verificamos se o usuário foi redirecionado para a página de listagem de veículos
        $response->assertRedirect(route('vehicles.index'));
    }
    
    #[Test]
    public function an_authenticated_user_can_view_vehicles_list()
    {
        
        $vehicle = Vehicle::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'brand_id' => $this->brand->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('vehicles.index'));

        $response->assertStatus(200);
        $response->assertSee($vehicle->plate);
    }
}
