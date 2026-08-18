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
        Schema::create('therapist_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('therapist_id');
            $table->integer('client_id');
            $table->integer('booking_id')->unsigned();
            $table->string('eval_punctuality');
            $table->string('eval_professionalism');
            $table->string('eval_communication');
            $table->string('eval_technique');
            $table->longText('comment');
            $table->tinyInteger('avg_evaluation');
            $table->string('ip_address');
            $table->tinyInteger('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapist_reviews');
    }
};
