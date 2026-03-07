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
        Schema::create('gift_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('voucher_id');
            $table->string('recipient_name');
            $table->string('recipient_email');
            $table->string('sender_name');
            $table->string('sender_email');
            $table->double('gift_amount', 8, 2);
            $table->text('message')->nullable();
            $table->double('used_amount', 8, 2);
            $table->double('remaining_amount', 8, 2);
            $table->string('gift_code');
            $table->enum('payment_status', ['in_progress', 'paid', 'failed']);
            $table->enum('payment_method', ['paypal', 'stripe', 'apple_pay']);
            $table->string('charge_id')->nullable();
            $table->datetime('send_at')->nullable();
            $table->datetime('expire_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_certificates');
    }
};
