<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Delivery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payment_method'  => $this->faker->randomElement(['Credit Card', 'Cash', 'PayPal', 'Crypto']),
            'currency'        => $this->faker->randomElement(['USD', 'EUR', 'LBP', 'BTC']),
            'payment_status'  => $this->faker->randomElement(['Pending', 'Completed', 'Failed']),
            'FX_rate'         => $this->faker->randomFloat(2, 1, 50),
            'deliveries_id'   => Delivery::inRandomOrder()->first()->id ?? Delivery::factory(),
        ];
    }
}
