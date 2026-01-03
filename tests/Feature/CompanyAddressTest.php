<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyAddressTest extends TestCase
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

    public function test_company_address(): void
    {

        $company = Company::factory()->create();

        $address = $company->address()->create(
            Address::factory()->make()->toArray()
        );
        $this->assertDatabaseHas('addresses',[
            'id' => $address->id,
            'addressable_id' => $company->id,
            'addressable_type' => Company::class,
        ]);
    }
        
    public function test_address_belongs_comapny(): void
    {
        $company = Company::factory()->create();

        $address = $company->address()->create(
            Address::factory()->make()->toArray()
        );

        $this->assertInstanceOf(Company::class, $address->addressable);
        $this->assertEquals($company->id, $address->addressable->id);

    }
}
