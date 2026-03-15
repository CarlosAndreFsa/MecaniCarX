<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserActiveTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function userAdminAtiveTest()
    {
        $admin = User::factory()->creaye([
            'role' => 'admin',
            'active' => true,
        ]);

        $user = User::factory()->create([
            'company_id' => $admin->company_id,
            'active' => true,
        ]);
        
        $this->actingAs($admin)
        ->patch(route('users.active', $user))
        ->assertRedirect();    
    }

    public function userAdminInactiveTest()
    {
        $admin = User::factory()->creaye([
            'role' => 'admin',
        ]);

        $user = User::factory()->create([
            'company_id' => $admin->company_id +1,
        
        ]);
        
        $this->actingAs($admin)
        ->patch(route('users.active', $user))
        ->assertStatus(403);    
    
    }

    public function userNotAdmin()
    {
        $employee = User::factory()->create([

            'role' => 'employee',
        ]);

        $user = User::factory()->create([
            'company_id' => $employee->company_id,
        ]);

        $this->actingAs($employee)
        ->patch(route('users.active'))
        ->assertStatus(403);
    }
}
