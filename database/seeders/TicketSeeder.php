<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\MovieSession;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем все сеансы
        $sessions = MovieSession::all();

        // Генерируем билеты для каждого сеанса
        foreach ($sessions as $session) {
            // Получаем случайные места для зала этого сеанса
            $seats = Seat::where('hall_id', $session->hall_id)->inRandomOrder()->limit(10)->get();

            foreach ($seats as $seat) {
                // Создаем билет
                Ticket::create([
                    'session_id' => $session->id,
                    'seat_id' => $seat->id,
                    'qr_code' => uniqid('ticket_', true), // Генерация уникального QR-кода
                ]);
            }
        }
    }
}