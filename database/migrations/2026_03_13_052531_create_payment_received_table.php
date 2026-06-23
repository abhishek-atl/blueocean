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
        Schema::create('payment_received', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('cash');
            $table->decimal('online');
            $table->decimal('amount');
            $table->decimal('tmr_commission');
            $table->decimal('therapist_commission');
            $table->decimal('vat');
            $table->decimal('total_hours');
            $table->string('stripe_payment_id')->nullable();
            $table->string('type');
            $table->string('status');
            $table->string('stripe_code')->nullable();
            $table->boolean('is_settled')->default(0);
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
        Schema::dropIfExists('payment_received');
    }
};
