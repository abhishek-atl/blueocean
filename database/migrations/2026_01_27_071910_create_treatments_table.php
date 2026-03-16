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
            $table->string('slug', 255)->unique();
            $table->string('name', 100);
            $table->string('title', 100);

            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();

            $table->longText('description');
            $table->boolean('active')->default(0);
            $table->boolean('on_treatment_page')->default(0);
            $table->longText('summary');
            $table->text('cta_text')->nullable();
            $table->boolean('cta_text_visible')->nullable();
            $table->boolean('cta_button_visible')->nullable();
            $table->string('cta_button_text', 255)->nullable();
            $table->string('cta_button_url', 255)->nullable();
            $table->string('description_heading', 255)->nullable();
            $table->string('benefits_heading', 255)->nullable();
            $table->longText('benefits')->nullable();

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
        Schema::dropIfExists('treatments');
    }
};
