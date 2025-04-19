<?php

namespace Database\Seeders;

use App\Models\User; // Assurez-vous que User est importé si vous l'utilisez directement ici
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Supprimez ceci si vous l'aviez

        $this->call([
            UserSeeder::class, // Ajoutez votre UserSeeder ici
            // Ajoutez d'autres seeders si nécessaire
            // PostSeeder::class,
            // CommentSeeder::class,
        ]);
    }
}
