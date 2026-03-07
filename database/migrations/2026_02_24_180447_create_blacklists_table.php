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
        Schema::create('blacklists', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 15)->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->enum('type', ['mobile', 'ip'])->nullable();
            $table->text('reason')->nullable();
            $table->unsignedInteger('requested_by')->nullable();
            $table->dateTime('requested_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blacklists');
    }
};
