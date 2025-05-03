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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('movie_sessions')->onDelete('cascade'); // Связь с сеансом
            $table->foreignId('seat_id')->constrained('seats')->onDelete('cascade')->unique(); // Добавляем уникальность
            $table->string('qr_code')->unique(); // Уникальный QR-код
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
