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
        Schema::create('trakings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('place_id');
            $table->string('name');
            $table->text('track_km')->nullable();
            $table->text('track_price')->nullable();
            $table->text('track_start_time')->nullable();
            $table->text('track_days')->nullable();
            $table->text('track_availability')->nullable();
            $table->text('track_description')->nullable();
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
        Schema::dropIfExists('trakings');
    }
};
