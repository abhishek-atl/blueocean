<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('booking_id')->unique()->constrained('bookings')->cascadeOnDelete();
            $table->unsignedTinyInteger('eval_respectful_behaviour');
            $table->unsignedTinyInteger('eval_communication');
            $table->unsignedTinyInteger('eval_booking_information_accuracy');
            $table->unsignedTinyInteger('eval_treatment_space_suitability');
            $table->boolean('felt_safe');
            $table->boolean('accept_future_booking');
            $table->decimal('avg_evaluation', 2, 1);
            $table->text('comment')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_reviews');
    }
};
