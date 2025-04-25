<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_admins_table.php

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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
             // Links to the user record where role='admin'
            $table->foreignId("user_id")
                  ->unique() // A user should only have one admin profile
                  ->constrained('users')
                  ->onUpdate("cascade")
                  ->onDelete("cascade");
            // Add any admin-specific fields if needed
            // e.g., $table->string('permission_level')->default('superadmin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
