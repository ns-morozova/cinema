<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')->constrained('cinema_halls')->onDelete('cascade'); // Связь с залом
            $table->integer('row')->unsigned(); // Номер ряда
            $table->integer('seat')->unsigned(); // Номер места в ряду
            $table->enum('type', ['vip', 'regular'])->default('regular'); // Тип места: VIP или обычное
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seats');
    }
}