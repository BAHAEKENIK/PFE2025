<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\ProviderService;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProviderService>
 */
class ProviderServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProviderService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id' => Provider::factory(), // Creates a Provider if none provided
            'service_id' => Service::factory(),   // Creates a Service if none provided
            // Add defaults for other pivot columns here if they exist
        ];
    }
}
