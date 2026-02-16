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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('birthday')->nullable();
            $table->string('mobile')->nullable();
            $table->string('postcode')->nullable();
            $table->string('flat_no')->nullable();
            $table->string('street_no')->nullable();
            $table->string('street_name')->nullable();
            $table->string('town')->nullable();
            $table->decimal('avg_rating', 2, 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
