<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_contact_messages_table.php

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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable(); // Added subject
            $table->text('message');
            $table->boolean('is_read')->default(false); // Track if admin read it
            $table->foreignId('replied_by_user_id')->nullable()->constrained('users'); // Track admin who replied
            $table->timestamp('replied_at')->nullable();
            $table->timestamps(); // Use timestamps()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
