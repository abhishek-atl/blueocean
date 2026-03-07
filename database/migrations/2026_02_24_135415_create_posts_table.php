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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('summary');
            $table->text('content');
            $table->string('author');
            $table->boolean('active')->default(true);
            $table->boolean('comments_enabled')->default(true);

            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('extra_meta_tags')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
