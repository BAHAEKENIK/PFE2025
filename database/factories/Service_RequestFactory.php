<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class Service_RequestFactory extends Factory
{
    protected $model = ServiceRequest::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'provider_id' => Provider::factory(),
            'service_id' => Service::factory(),
            'full_name' => fake()->name(),
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'budget' => fake()->randomFloat(2, 50, 1000),
            'service_date' => fake()->dateTimeBetween('+1 days', '+1 month')->format('Y-m-d'),
            'status' => fake()->randomElement(['pending', 'accepted', 'ignored', 'completed']),
        ];
    }
}
