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
        Schema::create('movie_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Связь с фильмом
            $table->foreignId('hall_id')->constrained('cinema_halls')->onDelete('cascade'); // Связь с кинозалом
            $table->dateTime('start_time'); // Время начала сеанса
            $table->dateTime('end_time'); // Время окончания сеанса
            $table->timestamps();
            $table->unique(['hall_id', 'start_time'], 'unique_session_per_hall_time');
        });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            $table->dropUnique('unique_session_per_hall_time');
        });
        
        Schema::dropIfExists('movie_sessions');
    }
};
