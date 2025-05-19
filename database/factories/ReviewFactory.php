<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\Delivery;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating'        => $this->faker->numberBetween(1, 5),
            'review'        => $this->faker->sentence(10),
            'deliveries_id' => Delivery::inRandomOrder()->first()->id ?? Delivery::factory(),
            'clients_id'    => Client::inRandomOrder()->first()->id ?? Client::factory(),
        ];
    }
}
