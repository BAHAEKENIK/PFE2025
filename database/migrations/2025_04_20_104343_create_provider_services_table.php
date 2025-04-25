<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_provider_services_table.php

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
        Schema::create('provider_services', function (Blueprint $table) {
            $table->id();
            // Correctly links to the providers table
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            // Add provider-specific details about this service if needed
            // e.g., $table->decimal('hourly_rate', 8, 2)->nullable();
            // e.g., $table->text('service_area_notes')->nullable();
            $table->timestamps(); // Use timestamps() for created_at and updated_at

            // Prevent duplicate entries
            $table->unique(['provider_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_services');
    }
};
