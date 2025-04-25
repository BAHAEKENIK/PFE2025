<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_providers_table.php

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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            // Links to the user record where role='provider'
            $table->foreignId("user_id")
                  ->unique() // A user should only have one provider profile
                  ->constrained('users')
                  ->onUpdate("cascade")
                  ->onDelete("cascade");
            $table->string("profession")->nullable(); // Primary profession/trade
            $table->float("average_rating")->nullable(); // Calculated/updated from reviews
            $table->float("experience_years")->nullable(); // More descriptive name
            $table->boolean('is_verified')->default(false); // For admin approval process
            // Add any other provider-specific fields
            // e.g., $table->string('business_name')->nullable();
            // e.g., $table->text('availability_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
