<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'    => $this->faker->firstName(),
            'last_name'     => $this->faker->lastName(),
            'age'           => $this->faker->numberBetween(18, 65),
            'phone'         => $this->faker->phoneNumber(),
            'email'         => $this->faker->unique()->safeEmail(),
            'premium_level' => $this->faker->randomElement(['Bronze', 'Silver', 'Gold']),
            'user_name'     => $this->faker->unique()->userName(),
            'password'      => bcrypt('password'), // Dummy password
            // 'password'      => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'user_id'       => User::inRandomOrder()->first()->id ?? User::factory(), // foreign key
            'cashback_rate' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}