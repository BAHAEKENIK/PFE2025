<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_clients_table.php

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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // Links to the user record where role='client'
            $table->foreignId("user_id")
                  ->unique() // A user should only have one client profile
                  ->constrained('users')
                  ->onUpdate("cascade")
                  ->onDelete("cascade");
            // Add any client-specific fields here if needed later
            // e.g., $table->integer('loyalty_points')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
