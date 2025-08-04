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
        Schema::create('usr_categ_and_cars', function (Blueprint $table) {
            $table->id();
			$table->foreignId('position_id')->constrained('positions');
			$table->foreignId('car_comfort_class_id')->constrained('car_comfort_class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usr_categ_and_cars');
    }
};