<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(), // or an existing ID
            'sender_id' => User::factory(),              // or an existing ID
            'message' => fake()->sentence(),
            'created_at' => now(),
        ];
    }
}
