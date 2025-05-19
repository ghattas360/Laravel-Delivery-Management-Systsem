<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client__Address>
 */
class ClientAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clients_id'   => Client::inRandomOrder()->first()->id ?? Client::factory(),
            'addresses_id' => Address::inRandomOrder()->first()->id ?? Address::factory(),
        ];

    }
}
