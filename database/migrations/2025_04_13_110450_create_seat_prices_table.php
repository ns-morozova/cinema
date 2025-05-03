<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatPricesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seat_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')->constrained('cinema_halls')->onDelete('cascade'); // Связь с залом
            $table->enum('seat_type', ['vip', 'standart', 'disabled'])->default('standart'); // Тип кресла
            $table->decimal('price', 8, 2)->unsigned()->nullable();
            $table->unique(['hall_id', 'seat_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_prices');
    }
}