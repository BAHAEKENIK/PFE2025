<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Provider;
use App\Models\Review;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create a service request to associate the review with
        // Ensure client and provider IDs match the request
        $serviceRequest = ServiceRequest::factory()->create();

        return [
            'service_request_id' => $serviceRequest->id,
            'client_id' => $serviceRequest->client_id,
            'provider_id' => $serviceRequest->provider_id,
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->optional(0.8)->paragraph(1), // 80% chance of having a comment
            'is_approved' => fake()->boolean(95), // 95% chance of being auto-approved
        ];
    }

    // Optional: Configure state to use existing ServiceRequest
     public function configure()
     {
         return $this->afterMaking(function (Review $review) {
             // If service_request_id is not set, find or create one
            if (!$review->service_request_id) {
                 $serviceRequest = ServiceRequest::factory()->create();
                 $review->service_request_id = $serviceRequest->id;
                 $review->client_id = $serviceRequest->client_id;
                 $review->provider_id = $serviceRequest->provider_id;
             } elseif($review->serviceRequest) { // If relationship is loaded
                $review->client_id = $review->serviceRequest->client_id;
                $review->provider_id = $review->serviceRequest->provider_id;
             }
         });
     }
}
