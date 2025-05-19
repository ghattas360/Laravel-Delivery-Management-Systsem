<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'picture'           => $this->faker->imageUrl(640, 480, 'transport', true),
            'height'            => $this->faker->randomFloat(2, 5, 50),  // cm
            'width'             => $this->faker->randomFloat(2, 5, 50),
            'depth'             => $this->faker->randomFloat(2, 5, 50),
            'weight'            => $this->faker->randomFloat(2, 0.5, 30), // kg
            'weight_unit'       => 'kg',
            'measurement_unit'  => 'cm',
            'is_breakable'      => $this->faker->boolean(30),
            'is_flammable'      => $this->faker->boolean(20),
            'has_fluid'         => $this->faker->boolean(15),
            'client_id'         => Client::inRandomOrder()->first()->id ?? Client::factory(),
        ];

    }
}
