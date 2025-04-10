<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CinemaHall;
use App\Models\Seat;

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
            ['name' => 'Зал 2', 'rows' => 8, 'seats_per_row' => 15],
            ['name' => 'Зал 3', 'rows' => 12, 'seats_per_row' => 25],
        ];

        // Добавление данных в таблицу через модель
        foreach ($halls as $hallData) {
            // Создаем зал
            $hall = CinemaHall::create($hallData);

            // Генерируем места для зала
            $seats = [];
            for ($row = 1; $row <= $hall->rows; $row++) {
                for ($seat = 1; $seat <= $hall->seats_per_row; $seat++) {
                    $type = ($row <= 2) ? 'vip' : 'regular'; // Первые два ряда — VIP
                    $seats[] = [
                        'hall_id' => $hall->id,
                        'row' => $row,
                        'seat' => $seat,
                        'type' => $type,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Массовое создание мест
            Seat::insert($seats);
        }
    }
}