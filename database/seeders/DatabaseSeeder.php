<?php

namespace Database\Seeders;

// database/seeders/DatabaseSeeder.php
use App\Models\User;
use App\Models\Review;
use App\Models\Service;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Certificate;
use App\Models\Conversation;
use App\Models\ContactMessage;
use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create one specific Admin
        User::factory()->admin()->hasAdmin(1)->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Create some Clients
        User::factory(10)->client()->hasClient(1)->create();

        // Create some Providers with Services and Certificates
        Provider::factory(15)
            ->has(Service::factory()->count(fake()->numberBetween(2, 5)), 'services') // Each provider offers 2-5 services
            ->has(Certificate::factory()->count(fake()->numberBetween(0, 3))) // Each provider has 0-3 certificates
            ->create(); // This automatically creates the associated User

        // Create some Service Requests and potentially Reviews
        ServiceRequest::factory(30)->create()->each(function ($request) {
            // Optionally create a review for completed/accepted requests
            if (in_array($request->status, ['completed', 'accepted']) && fake()->boolean(60)) { // 60% chance for a review
                Review::factory()->create([
                    'service_request_id' => $request->id,
                    'client_id' => $request->client_id,
                    'provider_id' => $request->provider_id,
                ]);
            }
        });

         // Create some categories without services initially (services were created via providers above)
         Category::factory(8)->create();

        // Create some conversations and messages
         Conversation::factory(20)->hasMessages(fake()->numberBetween(5, 15))->create();

        // Create some contact messages
        ContactMessage::factory(10)->create();
    }
}
