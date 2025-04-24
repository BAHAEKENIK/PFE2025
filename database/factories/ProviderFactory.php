<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profession' => fake()->jobTitle(),
            'user_id' => User::factory(),
            'rating' => fake()->randomFloat(1, 1, 5), // rating between 1.0 and 5.0
            'experience' => fake()->randomFloat(1, 0, 30),
        ];
    }
}