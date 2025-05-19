<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Region;
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
    public function definition(): array
    {
        return [
            'street'      => $this->faker->streetName,
            'house_number'=> $this->faker->buildingNumber,
            'building'    => $this->faker->company,
            'zip_code'    => $this->faker->numberBetween(1000, 9999),
            'coordinates' => $this->faker->latitude . ',' . $this->faker->longitude,
            'floor'       => $this->faker->numberBetween(0, 10),
            'type'        => $this->faker->randomElement(['Home', 'Work', 'Other']),
            'region_id'   => Region::inRandomOrder()->first()->id ?? Region::factory(), // foreign key
        ];
    }
}
