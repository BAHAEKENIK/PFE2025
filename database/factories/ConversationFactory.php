<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ensure two different users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Ensure user_one_id < user_two_id for consistency (optional)
        $ids = collect([$user1->id, $user2->id])->sort()->values();

        return [
            'user_one_id' => $ids[0],
            'user_two_id' => $ids[1],
        ];
    }
}
