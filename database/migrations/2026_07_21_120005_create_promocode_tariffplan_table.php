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
        Schema::create('promocode_tariff_plan', function (Blueprint $table) {
            $table->id();
            $table->integer('promocode_id');
            $table->integer('tariff_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocode_tariff_plan');
    }
};
