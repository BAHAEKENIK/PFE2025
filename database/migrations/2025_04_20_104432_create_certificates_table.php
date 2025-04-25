<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_certificates_table.php

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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            // *** Changed to link to providers table ***
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->string('title');
            // *** Path for the uploaded image/file ***
            $table->string('certificate_image_path')->nullable();
             // *** Link (URL) for the certificate (optional) ***
            $table->string('certificate_link')->nullable();
            $table->string('issued_by')->nullable(); // Issuing authority
            $table->date('issued_at')->nullable();   // Date issued
            $table->date('expires_at')->nullable();  // Optional expiry date
            $table->timestamps(); // Use timestamps()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
