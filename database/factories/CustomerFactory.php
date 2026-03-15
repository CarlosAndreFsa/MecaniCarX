<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'name_fantasy' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf_cnpj' => $this->faker->unique()->numerify('##############'),
            'phone' => $this->faker->phoneNumber(),
            'active' => $this->faker->boolean(90), // 90% chance of being active
            'website' => $this->faker->url(),
        ];
    }
}
