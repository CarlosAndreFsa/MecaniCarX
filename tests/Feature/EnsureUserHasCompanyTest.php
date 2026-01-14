<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnsureUserHasCompanyTest extends TestCase
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

    public function user_with_comapny_acesss_protected()
    {
        $company = Company::factory()->create();

        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($user)->get('/company-test');

        $response->assertStatus(200);

    }

    public function user_without_company_cannot_protected()
    {
         $user = User::factory()->create([
            'company_id' => null,
        ]);

        $response = $this->actingAs($user)->get('/company-test');

        $response->assertStatus(403);

    }

}
