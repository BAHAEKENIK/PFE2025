<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_conversations_table.php

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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            // Ensure user_one_id < user_two_id in application logic to prevent duplicates like (1,2) and (2,1)
            $table->foreignId('user_one_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_two_id')->constrained('users')->onDelete('cascade');
            $table->timestamps(); // Use timestamps()

            // Unique constraint to prevent duplicate conversations
            $table->unique(['user_one_id', 'user_two_id']);
            // Indexes for faster lookups
            $table->index(['user_one_id']);
            $table->index(['user_two_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
