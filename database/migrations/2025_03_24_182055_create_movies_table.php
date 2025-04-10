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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название фильма
            $table->text('description')->nullable(); // Описание фильма
            $table->integer('duration')->unsigned(); // Продолжительность в минутах
            $table->string('country')->nullable(); // Страна фильма
            $table->decimal('price_vip', 8, 2); // Цена VIP-билета
            $table->decimal('price_regular', 8, 2); // Цена обычного билета
            $table->string('poster')->nullable(); // Добавляем колонку "poster"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
