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
        Schema::create('ride_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 32);
            $table->string('pickup_location', 120);
            $table->string('drop_location', 120);
            $table->string('pickup_district', 40);
            $table->date('pickup_date');
            $table->string('car_type', 20);
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
        Schema::dropIfExists('ride_requests');
    }
};
