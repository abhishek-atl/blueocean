<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapists_mandates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('therapist_id')->nullable();
            $table->string('stripe_customer_id');
            $table->string('checkout_session_id')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->string('mandate_id')->nullable();
            $table->string('setup_intent_id')->nullable();
            $table->boolean('is_enabled')->default(1);
            $table->boolean('is_default')->default(0);
            $table->string('bank_last_four_digits')->nullable();
            $table->string('stripe_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapists_mandates');
    }
};
