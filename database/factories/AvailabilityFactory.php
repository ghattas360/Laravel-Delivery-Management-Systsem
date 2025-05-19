<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Driver;
use App\Models\Shift;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability>
 */
class AvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'set_at'       => $this->faker->dateTimeBetween('-1 week', 'now'),
            'drivers_id'   => Driver::inRandomOrder()->first()->id ?? Driver::factory(),
            'shifts_id'    => Shift::inRandomOrder()->first()->id ?? Shift::factory(),
        ];
    }
}
