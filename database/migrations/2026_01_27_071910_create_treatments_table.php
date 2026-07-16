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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('title', 100);
            $table->string('slug', 255)->unique();
            $table->longText('description');
            $table->longText('technique');
            $table->longText('ideal_for');

            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();

            $table->boolean('active')->default(0);
            $table->boolean('on_treatment_page')->default(0);

            $table->string('page_meta_title', 255);
            $table->longText('page_meta_description');
            $table->string('page_extra_meta_tags', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
