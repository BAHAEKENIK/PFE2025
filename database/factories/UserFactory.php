<?php

namespace Database\Factories;

use App\Models\User; // Assurez-vous que le chemin vers votre modèle User est correct
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(), // Décommentez si vous avez cette colonne et souhaitez la remplir
            'password' => static::$password ??= Hash::make('password'), // Définit un mot de passe par défaut "password"
            'role' => 'client', // Par défaut, crée des clients
            'phone' => $this->faker->optional()->phoneNumber(), // Rend le téléphone optionnel (peut être null)
            'city' => $this->faker->optional()->city(),      // Rend la ville optionnelle
            'profile_photo' => null, // Vous pouvez mettre une URL d'image placeholder si vous voulez
            'bio' => $this->faker->optional()->paragraph(2), // Rend la bio optionnelle
            // 'remember_token' => Str::random(10), // Décommentez si vous utilisez remember_token
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     * Décommentez cette méthode si vous avez 'email_verified_at'
     */
    /*
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    */

    /**
     * Permet de spécifier un rôle lors de la création via la factory
     * Exemple : User::factory()->withRole('admin')->create();
     */
    public function withRole(string $role): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => $role,
        ]);
    }
}
