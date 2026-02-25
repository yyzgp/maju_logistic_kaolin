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
        Schema::create('singapore_locations', function (Blueprint $table) {
            $table->id();
            $table->string('place')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->double('latitude', 10, 8)->nullable();
            $table->double('longitude', 11, 8)->nullable();
            $table->double('bounding_box_1', 11, 8)->nullable();
            $table->double('bounding_box_2', 11, 8)->nullable();
            $table->double('bounding_box_3', 11, 8)->nullable();
            $table->double('bounding_box_4', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('singapore_locations');
    }
};
