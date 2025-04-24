<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CertificateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'provider_id' => User::factory(), // assumes provider is a user
            'title' => fake()->sentence(3),
            'file_path' => 'certificates/' . fake()->uuid() . '.pdf',
            'issued_by' => fake()->company(),
            'issued_at' => fake()->date(),
            'created_at' => Carbon::now(),
        ];
    }
}
