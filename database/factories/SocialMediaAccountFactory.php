<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\SocialMediaProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Social__Media__Account>
 */
class SocialMediaAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clients_id'                => Client::inRandomOrder()->first()->id ?? Client::factory(),
            'social_media_providers_id'=> SocialMediaProvider::inRandomOrder()->first()->id ?? SocialMediaProvider::factory(),
            'account_name'             => $this->faker->userName,
            'profile_url'              => $this->faker->url,
            'is_active'                => $this->faker->boolean(90),
        ];
    }
}
