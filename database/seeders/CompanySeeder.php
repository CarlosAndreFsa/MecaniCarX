<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Company::factory(5)->create();
        Company::factory(5)->create()->each(function ($company) {
            $company->address()->create(
                Address::factory()->make()->toArray()
            );

        });
    }
}
