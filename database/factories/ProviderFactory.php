<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Ensure the associated user has the 'provider' role
            'user_id' => User::factory()->provider(), // Creates a user with provider role
            'profession' => fake()->jobTitle(),
            'average_rating' => fake()->optional(0.7)->randomFloat(1, 3, 5), // 70% chance of having a rating
            'experience_years' => fake()->optional(0.8)->randomFloat(1, 1, 15), // 80% chance of having experience listed
            'is_verified' => fake()->boolean(75), // 75% chance of being verified
        ];
    }
}
