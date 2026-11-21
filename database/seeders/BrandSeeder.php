<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Audi',
            'BMW',
            'BYD',
            'Caoa Chery',
            'Chevrolet',
            'Citroën',
            'Dodge',
            'Fiat',
            'Ford',
            'GWM',
            'Honda',
            'Hyundai',
            'Iveco',
            'JAC',
            'Jeep',
            'Kia',
            'Land Rover',
            'Mercedes-Benz',
            'Mitsubishi',
            'Nissan',
            'Peugeot',
            'Porsche',
            'RAM',
            'Renault',
            'Subaru',
            'Suzuki',
            'Toyota',
            'Volkswagen',
            'Volvo',
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate([
                'name' => $brand,
            ]);
        }
    }
}
