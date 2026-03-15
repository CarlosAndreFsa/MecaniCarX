<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define o estado padrão do modelo.
     */
    public function definition(): array
    {
        return [
            // Isso vai gerar nomes como "Toyota", "Ford", etc., via Faker
            'name' => $this->faker->unique()->company(), 
        ];
    }
}