<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Importez votre modèle User
use Illuminate\Support\Facades\Hash; // Importez Hash si besoin (même si la factory le gère)

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optionnel: Supprimer les anciens utilisateurs avant de seeder pour éviter les doublons d'email unique
        // User::query()->delete(); // Soyez prudent avec ceci en production !

        // 1. Créer l'administrateur unique
        User::factory()->create([
            'name' => 'BAHAE KENIKSSI',
            'email' => 'bahaekenik@gmail.com', // Utilisez une adresse email spécifique et facile à retenir
            'password' => Hash::make('BAHAE8672Bahae'), // Utilisez un mot de passe spécifique pour l'admin
            'role' => 'admin',
            // Vous pouvez ajouter d'autres champs spécifiques à l'admin ici si nécessaire
            // 'phone' => '123456789',
            // 'city' => 'AdminCity',
        ]);

        // 2. Créer 10 clients
        // La factory crée des 'client' par défaut, donc pas besoin de spécifier le rôle ici.
        User::factory()->count(10)->create();

        // 3. Optionnel: Créer quelques prestataires (providers) si nécessaire
        // User::factory()->count(5)->create(['role' => 'provider']);
        // OU en utilisant la méthode d'état personnalisée :
        // User::factory()->count(5)->withRole('provider')->create();

        // Afficher un message dans la console (optionnel)
        $this->command->info('UserSeeder executed successfully!');
        $this->command->info('Created 1 Admin (admin@example.com / adminpassword)');
        $this->command->info('Created 10 Client users (password: password)');
    }
}
