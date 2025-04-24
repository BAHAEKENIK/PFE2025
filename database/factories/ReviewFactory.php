<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Provider;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'service_request_id' => ServiceRequest::factory(),
            'client_id' => Client::factory(),
            'provider_id' => Provider::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->optional()->paragraph(),
        ];
    }
}
