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
            $table->foreignId('session_id')->constrained()->onDelete('cascade'); // Связь с сеансом
            $table->integer('row')->unsigned(); // Номер ряда
            $table->integer('seat')->unsigned(); // Номер места
            $table->enum('type', ['vip', 'standart']); // Тип места
            $table->string('qr_code')->unique(); // Уникальный QR-код
            $table->enum('status', ['booked', 'available'])->default('available'); // Статус бронирования
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
