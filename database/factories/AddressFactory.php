<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'zip_code'   => $this->faker->postcode(),
            'street'     => $this->faker->streetName(),
            'number'     => $this->faker->buildingNumber(),
            'complement' => $this->faker->optional()->secondaryAddress(),
            'district'   => $this->faker->citySuffix(),
            'city'       => $this->faker->city(),
            'state'      => $this->faker->stateAbbr(),
            'country'    => 'BR',
        ];
    }
}
