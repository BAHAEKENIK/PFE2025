<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isRead = fake()->boolean(60); // 60% chance of being read
        $repliedByUser = $isRead && fake()->boolean(40) ? User::where('role', 'admin')->inRandomOrder()->first() ?? User::factory()->admin()->create() : null; // 40% chance of replied if read

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'subject' => fake()->optional()->sentence(4),
            'message' => fake()->paragraph(3),
            'is_read' => $isRead,
            'replied_by_user_id' => $repliedByUser?->id,
            'replied_at' => $repliedByUser ? fake()->dateTimeThisMonth() : null,
        ];
    }
}
