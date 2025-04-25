<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->bs(), // Generates plausible service names like "optimize synergistic schemas"
            'description' => fake()->optional()->paragraph(2),
            'category_id' => Category::factory(), // Creates a Category if none provided
            'is_active' => fake()->boolean(90), // 90% chance of being active
        ];
    }
}
