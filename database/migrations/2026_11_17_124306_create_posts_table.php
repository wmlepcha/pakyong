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
            $table->string('category')->index();
            $table->text('excerpt')->nullable();
            $table->text('intro')->nullable();
            $table->json('sections')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->date('published_at')->nullable()->index();
            $table->date('updated_on')->nullable();
            $table->unsignedSmallInteger('mins')->nullable();
            $table->string('seo_description')->nullable();
            $table->boolean('is_published')->default(false);
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
