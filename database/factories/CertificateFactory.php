<?php

namespace Database\Factories;

use App\Models\Certificate;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id' => Provider::factory(), // Creates a Provider if none provided
            'title' => fake()->catchPhrase() . ' Certification',
            'certificate_image_path' => null, // Or fake()->imageUrl()
            'certificate_link' => fake()->optional()->url(),
            'issued_by' => fake()->optional()->company(),
            'issued_at' => fake()->optional()->date(),
            'expires_at' => optional(fake()->optional()->dateTimeBetween('now', '+5 years'))->format('Y-m-d'),

        ];
    }
}
