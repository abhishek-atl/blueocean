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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('booking_id');
            $table->integer('amount');
            $table->decimal('gift_discount_amount', 8, 2)->default(0);
            $table->integer('refund_amount')->nullable();
            $table->enum('payment_type', ['cash', 'credit', 'stripe', 'gift_voucher']);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded']);
            $table->string('charge_id', 150)->nullable()->comment('Stripe Charge ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
