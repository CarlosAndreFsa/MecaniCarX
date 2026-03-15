<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\Customer::factory(),
            'brand_id' => \App\Models\Brand::factory(),
            'model' => $this->faker->word(),
            'plate' => strtoupper($this->faker->bothify('???-####')),
            'year' => $this->faker->numberBetween(1990, date('Y')),
            'color' => $this->faker->safeColorName(),
             'vin' => strtoupper($this->faker->bothify('#################')), // VIN
        ];
    }
}
