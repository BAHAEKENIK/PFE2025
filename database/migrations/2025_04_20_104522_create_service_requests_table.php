<?php

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
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('provider_id')->constrained('providers');
            $table->foreignId('service_id')->constrained('services');
            $table->string('full_name');
            $table->text("description");
            $table->text('address');
            $table->decimal('budget', 10, 2);
            $table->date('service_date');
            $table->enum('status', ['pending', 'accepted', 'ignored', 'completed'])->default('pending');
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
