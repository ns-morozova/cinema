<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CinemaHall;

class CinemaHallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Данные для вставки
        $halls = [
            ['name' => 'Зал 1', 'rows' => 10, 'seats_per_row' => 20],
            ['name' => 'Зал 2', 'rows' => 10, 'seats_per_row' => 20],
            ['name' => 'Зал 3', 'rows' => 10, 'seats_per_row' => 20],
        ];

        // Добавление данных в таблицу через модель
        foreach ($halls as $hallData) {
            CinemaHall::create($hallData);
        }
    }
}
