<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(5)->create();
        $company = Company::factory()->create();

        User::factory(5)->create([
            'company_id' => $company->id,
        ]);

    }
}
