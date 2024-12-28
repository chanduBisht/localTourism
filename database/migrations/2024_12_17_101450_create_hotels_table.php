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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('place_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('facility')->nullable();
            $table->text('location')->nullable();
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
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
        Schema::dropIfExists('hotels');
    }
};
