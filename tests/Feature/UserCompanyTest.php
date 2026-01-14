<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    use RefreshDatabase;

    public function test_belongs_to_company()
    {
        $company = Company::factory()->create();

        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->assertNotNull($user->company);
        $this->assertEquals($company->id, $user->company->id);
    }

    public function test_has_many_company()
    {
        $company  = Company::factory()->create();

       User::factory(3)->create([
            'company_id' => $company->id,
        ]);

        $this->assertCount(3, $company->users);

    }
}
