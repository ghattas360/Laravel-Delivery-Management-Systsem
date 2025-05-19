<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SocialMediaProvider;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Social__Media__Provider>
 */
class SocialMediaProviderFactory extends Factory
{
    protected $model = SocialMediaProvider::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Facebook', 'Google', 'Twitter', 'Apple']),
            'url'  => $this->faker->url,
        ];
    }
}
