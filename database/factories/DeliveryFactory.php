<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;
use App\Models\Driver;
use App\Models\Package;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'status'             => $this->faker->randomElement(['Pending', 'In Progress', 'Delivered', 'Canceled']),
            'takeOf_Address_id'  => Address::inRandomOrder()->first()->id ?? Address::factory(),
            'dropOf_Address_id'  => Address::inRandomOrder()->first()->id ?? Address::factory(),
            'cost'               => $this->faker->randomFloat(2, 5, 150),
            'currency'           => $this->faker->currencyCode,
            'scheduled_at'       => $this->faker->dateTimeBetween('now', '+7 days'),
            'drivers_id'         => Driver::inRandomOrder()->first()->id ?? Driver::factory(),
            'packages_id'        => Package::inRandomOrder()->first()->id ?? Package::factory(),
        ];
    }
}
