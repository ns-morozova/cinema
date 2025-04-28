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
        Schema::create('cinema_halls', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название зала
            $table->integer('rows')->unsigned(); // Количество рядов
            $table->integer('seats_per_row')->unsigned(); // Количество мест в ряду
            $table->timestamps();
            $table->boolean('enabled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinema_halls');
    }
};
