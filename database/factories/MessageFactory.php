<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $conversation = Conversation::factory()->create();
        $senderId = fake()->randomElement([$conversation->user_one_id, $conversation->user_two_id]);

        return [
            'conversation_id' => $conversation->id,
            'sender_id' => $senderId,
            'message' => fake()->sentence(),
            'read_at' => fake()->optional(0.5)->dateTimeThisMonth(), // 50% chance of being read
        ];
    }

    // Optional: Configure state to use existing Conversation
    public function configure()
    {
        return $this->afterMaking(function (Message $message) {
            if ($message->conversation_id && !$message->sender_id) {
                 // If conversation exists, randomly pick a sender from it
                 $message->sender_id = fake()->randomElement([
                     $message->conversation->user_one_id,
                     $message->conversation->user_two_id
                 ]);
            } elseif (!$message->conversation_id) {
                // Create conversation and assign sender if none provided
                $conversation = Conversation::factory()->create();
                $message->conversation_id = $conversation->id;
                $message->sender_id = fake()->randomElement([$conversation->user_one_id, $conversation->user_two_id]);
            }
        });
    }
}
