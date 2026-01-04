<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::factory()->create([
            'name' => 'Oficina Demo',
        ]);

        User::factory()->create([
            'company_id' => $company->id,
            'name' => 'Admin',
            'email' => 'admin@mecanicarx.com.br',
            'password' => Hash::make('password'),
        ]);
    }
}
