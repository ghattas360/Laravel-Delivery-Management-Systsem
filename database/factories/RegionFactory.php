<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country'      => $this->faker->country,
            'state'        => $this->faker->state,
            'city'         => $this->faker->city,
            'region_name'  => $this->faker->word . ' Region',
            'created_on'   => now(),
        ];
    }
}
