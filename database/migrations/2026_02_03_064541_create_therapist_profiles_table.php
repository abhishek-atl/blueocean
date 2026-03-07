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
        Schema::create('therapist_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->longText('about')->nullable();
            $table->longText('notes')->nullable();
            $table->date('health_renewal_date')->nullable();
            $table->boolean('health_professional')->default(false);
            $table->decimal('extend_cost', 10, 2)->nullable();
            $table->decimal('fee_therapist_60', 10, 2)->nullable();
            $table->decimal('fee_therapist_90', 10, 2)->nullable();
            $table->decimal('fee_therapist_120', 10, 2)->nullable();
            $table->decimal('fee_therapist_150', 10, 2)->nullable();
            $table->decimal('fee_therapist_180', 10, 2)->nullable();
            $table->decimal('fee_therapist_210', 10, 2)->nullable();
            $table->boolean('on_therapist_page')->default(false);
            $table->boolean('soothing')->default(false);
            $table->boolean('strong')->default(false);
            $table->boolean('z_chair')->default(false);
            $table->boolean('massage_table')->default(false);
            $table->boolean('gender')->default(false);
            $table->decimal('avg_rating', 2, 1)->nullable();
            $table->boolean('bonus_eligible')->nullable();
            $table->decimal('bonus_amount', 8, 2)->nullable();

            $table->string('page_meta_title', 255);
            $table->longText('page_meta_tag');
            $table->string('extra_meta_tags', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapist_profiles');
    }
};
