<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition(): array
    {
        $userOne = User::inRandomOrder()->first() ?? User::factory()->create();
        $userTwo = User::inRandomOrder()->where('id', '!=', $userOne->id)->first();

        // Fallback if no second user found
        if (!$userTwo) {
            $userTwo = User::factory()->create();
        }

        return [
            'user_one_id' => $userOne->id,
            'user_two_id' => $userTwo->id,
            'created_at' => now(),
        ];
    }
}
