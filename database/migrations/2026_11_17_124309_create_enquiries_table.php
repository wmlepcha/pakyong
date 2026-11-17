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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 32);
            $table->json('destinations')->nullable();
            $table->string('tier', 32)->nullable();
            $table->string('traveller', 32)->nullable();
            $table->string('season', 32)->nullable();
            $table->date('start_date')->nullable();
            $table->unsignedTinyInteger('days')->nullable();
            $table->unsignedSmallInteger('people')->nullable();
            $table->unsignedInteger('budget')->nullable();
            $table->string('stay', 64)->nullable();
            $table->string('package')->nullable();
            $table->string('status', 24)->default('new')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
