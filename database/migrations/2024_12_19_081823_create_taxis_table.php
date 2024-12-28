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
        Schema::create('taxis', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('place_id');
            $table->string('name');
            $table->text('car_number')->nullable();
            $table->text('car_price')->nullable();
            $table->text('car_availability')->nullable();
            $table->text('car_description')->nullable();
            $table->text('image')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxis');
    }
};
