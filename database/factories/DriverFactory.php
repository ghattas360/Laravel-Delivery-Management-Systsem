<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username'        => $this->faker->unique()->userName,
            'password'        => bcrypt('password'),
            'first_name'      => $this->faker->firstName,
            'last_name'       => $this->faker->lastName,
            'age'             => $this->faker->numberBetween(21, 60),
            'phone'           => $this->faker->phoneNumber,
            'email'           => $this->faker->unique()->safeEmail,
            'driving_license' => strtoupper($this->faker->bothify('DL######')),
            'national_id'     => strtoupper($this->faker->bothify('ID########')),
            'plate_number'    => strtoupper($this->faker->bothify('ABC-####')),
            'pricing_model'   => $this->faker->randomElement(['per_kilometer', 'per_delivery']),
            'is_active'       => true,
            'user_id'         => User::inRandomOrder()->first()->id ?? User::factory(),
            'path1'           => $this->faker->unique()->url, // Optional: a realistic URL
            'path2'           => $this->faker->unique()->url, // Optional: a realistic URL
            'latitude' => fake()->latitude(33.8, 34.0),     // Beirut & surroundings
            'longitude' => fake()->longitude(35.4, 35.6),   // Beirut & surroundings

        ];

    }
}
