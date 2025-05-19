<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'age'        => $this->faker->numberBetween(22, 60),
            'role'       => $this->faker->randomElement(['Admin', 'Manager', 'Support']),
            'username'   => $this->faker->unique()->userName,
            'password'   => bcrypt('password'), // hashed password
            'is_active'  => true,
            'address_id' => Address::inRandomOrder()->first()->id ?? Address::factory(),
        ];

    }
}
