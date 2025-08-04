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
		Schema::create('trips', function (Blueprint $table) {
			$table->id();
			$table->foreignId('staff_id')->constrained('staffs');
			$table->foreignId('car_id')->constrained('cars');
			$table->timestamp('start_time');
			$table->timestamp('end_time');
			$table->string('destination');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};