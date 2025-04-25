<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceRequest>
 */
class ServiceRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),     // Creates a Client if none provided
            'provider_id' => Provider::factory(), // Creates a Provider if none provided
            'service_id' => Service::factory(),   // Creates a Service if none provided
            'full_name' => fake()->name(),         // Contact name for the request
            'description' => fake()->paragraph(3),
            'address' => fake()->address(),
            'budget' => fake()->optional(0.6)->randomFloat(2, 50, 1500), // 60% chance of having a budget
            'preferred_datetime' => fake()->dateTimeBetween('+2 days', '+1 month'),
            'status' => fake()->randomElement(['pending', 'accepted', 'rejected', 'in_progress', 'completed', 'cancelled']),
        ];
    }
}
