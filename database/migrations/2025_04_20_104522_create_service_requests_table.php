<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_service_requests_table.php

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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            // *** Changed to link to clients table ***
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Requesting client
             // *** Changed to link to providers table ***
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade'); // Requested provider
            $table->foreignId('service_id')->constrained('services'); // Requested service type

            $table->string('full_name'); // Name for the service location/contact (might differ from client user name)
            $table->text("description"); // Client's description of the needed work
            $table->text('address'); // Address where service is needed
            $table->decimal('budget', 10, 2)->nullable(); // Client's budget (optional)
            $table->dateTime('preferred_datetime'); // Changed to dateTime for more precision
            $table->enum('status', ['pending', 'accepted', 'rejected', 'in_progress', 'completed', 'cancelled'])
                  ->default('pending'); // Added more relevant statuses
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
