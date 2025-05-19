<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Availability;
use App\Models\Region;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability__Region>
 */
class AvailabilityRegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'availabilities_id' => Availability::inRandomOrder()->first()->id ?? Availability::factory(),
            'regions_id'        => Region::inRandomOrder()->first()->id ?? Region::factory(),
        ];
    }
}
