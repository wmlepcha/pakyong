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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('region')->default('Sikkim')->index();
            $table->string('name');
            $table->string('short')->nullable();
            $table->string('card_image')->nullable();
            $table->string('hero_image')->nullable();
            $table->boolean('home_tile')->default(false);
            $table->unsignedSmallInteger('tile_order')->default(0);
            $table->string('base')->nullable();
            $table->string('days')->nullable();
            $table->string('high')->nullable();
            $table->string('elev')->nullable();
            $table->string('tagline')->nullable();
            $table->string('places_line')->nullable();
            $table->json('good_for')->nullable();
            $table->json('about')->nullable();
            $table->json('calendar')->nullable();
            $table->json('seasons')->nullable();
            $table->json('pack_always')->nullable();
            $table->json('places')->nullable();
            $table->json('getting')->nullable();
            $table->text('permits')->nullable();
            $table->text('stay')->nullable();
            $table->json('itinerary')->nullable();
            $table->json('tips')->nullable();
            $table->json('faqs')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
