<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\ProviderService;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Provider_ServicesFactory extends Factory
{
    protected $model =ProviderService::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id'=>Provider::factory(),
            'service_id'=>Service::factory(),
        ];
    }
}