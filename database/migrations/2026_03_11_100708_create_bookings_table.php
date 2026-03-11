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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('treatment_id');
            $table->dateTime('booking_datetime');
            $table->dateTime('appointment_start');
            $table->dateTime('appointment_finish');

            $table->string('name', 100);
            $table->string('email', 50)->nullable();
            $table->string('phone', 14);
            $table->string('postcode', 50);
            $table->longText('address');
            $table->string('flat_no', 50)->nullable();
            $table->string('street_number', 50);
            $table->string('street_name', 50)->nullable();
            $table->string('town', 100);
            $table->longText('comments')->nullable();


            $table->integer('duration');
            $table->integer('extra_duration')->default(0);
            $table->decimal('cost', 10, 2);
            $table->decimal('training_cost', 10, 2);
            $table->decimal('fee_platform', 10, 2);
            $table->decimal('fee_therapist', 10, 2);
            $table->decimal('fee_extension', 10, 2)->nullable();
            $table->decimal('fee_therapist_extension', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->string('discount_code', 50)->nullable();
            $table->decimal('gift_discount_amount', 10, 2)->nullable();
            $table->decimal('gift_discount_remaining_amount', 8, 2)->nullable();
            $table->string('gift_discount_code', 100)->nullable();
            $table->boolean('paid_by_therapist')->default(false);
            $table->decimal('travel_supp', 10, 2)->nullable();
            $table->boolean('therapist_conf_sms')->default(false);
            $table->enum('status', ['new', 'cancelled', 'processing'])->nullable();
            $table->text('late_reason')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->dateTime('cancellation_requested_at')->nullable();
            $table->boolean('is_extension_paid')->nullable();

            $table->tinyInteger('therapist_rating')->nullable();
            $table->tinyInteger('client_rating')->nullable();

            $table->enum('device', ['mobile', 'desktop'])->nullable();
            $table->string('client_ip_address', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
