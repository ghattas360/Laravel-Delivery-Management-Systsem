<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create a logical shift with start before end
        $start = $this->faker->dateTimeBetween('08:00:00', '14:00:00');
        $end   = (clone $start)->modify('+4 hours');

        return [
            'starting_time' => $start,
            'end_time'      => $end,
            'date'          => $this->faker->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d'),
        ];

    }
}
