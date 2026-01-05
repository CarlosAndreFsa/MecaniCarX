<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
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

    protected function createUser(array $overrides = []): User
    {
        $company = Company::factory()->create();

        return User::factory()->create(array_merge([
            'company_id' => $company->id,
            'active' => true,
            'role'  => 'employee',
        ], $overrides));
    }
    
    public function test_admin_can_acess_dashboard()
    {
        $user = $this->createUser(['role' =>'admin']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_employee_can_access_dashboard()
    {
        $user = $this->createUser(['role' => 'employee']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_client_cannot_access_dashboard()
    {
        $user = $this->createUser(['role' => 'client']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(403);
    }

    public function test_inactive_user_cannot_access_dashboard()
    {
        $user = $this->createUser(['active' => false]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(403);
    }

    public function test_user_without_company_cannot_access_dashboard()
    {
        $user = User::factory()->create([
            'company_id' => null,
            'active' => true,
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(403);
    }


}
