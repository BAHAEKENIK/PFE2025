<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_reviews_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Link to the specific request being reviewed
            $table->foreignId('service_request_id')->unique()->constrained('service_requests')->onDelete('cascade'); // Only one review per request
            // *** Changed to link to clients table ***
            $table->foreignId('client_id')->constrained('clients'); // Who wrote the review
             // *** Changed to link to providers table ***
            $table->foreignId('provider_id')->constrained('providers'); // Who is being reviewed
            $table->unsignedTinyInteger('rating'); // Rating 1-5 (validation in code)
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(true); // Admin might moderate reviews
            $table->timestamps();

            // Index for faster lookups of provider reviews
            $table->index(['provider_id', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
