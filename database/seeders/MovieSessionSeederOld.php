<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\MovieSession;
use Carbon\Carbon;
use Schema;

class MovieSessionSeederOld extends Seeder
{
    public function run()
    {

        // Проверяем наличие таблиц
        if (!Schema::hasTable('cinema_halls') || !Schema::hasTable('movies')) {
            $this->command->error('Таблицы cinema_halls или movies не существуют.');
            return;
        }
        // Получаем все залы и фильмы
        $cinemaHalls = CinemaHall::all();
        $movies = Movie::all();

        // Проверяем, что есть данные для работы
        if ($cinemaHalls->isEmpty() || $movies->isEmpty()) {
            $this->command->info('Необходимо добавить залы и фильмы перед созданием сеансов.');
            return;
        }

        // Начальная дата и временной интервал
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addMonth()->endOfDay();
        $startTime = Carbon::createFromTime(9, 0); // Работа с 9:00
        $endTime = Carbon::createFromTime(23, 0); // Работа до 23:00

        // Интервал между сеансами
        $interval = 30; // Минут

        // Генерация сеансов
        foreach ($cinemaHalls as $hall) {
            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                $currentTime = $startTime->copy();

                while ($currentTime->lte($endTime)) {
                    // Выбираем случайный фильм
                    $movie = $movies->random();

                    // Рассчитываем время окончания сеанса
                    $sessionEndTime = $currentTime->copy()->addMinutes($movie->duration + $interval);

                    // Если время окончания выходит за границы рабочего времени, пропускаем
                    if ($sessionEndTime->gt($endTime)) {
                        break;
                    }

                    // Создаем сеанс
                    MovieSession::create([
                        'movie_id' => $movie->id,
                        'hall_id' => $hall->id,
                        'start_time' => $currentTime->toDateTimeString(),
                        'end_time' => $sessionEndTime->toDateTimeString(),
                    ]);

                    // Обновляем текущее время
                    $currentTime = $sessionEndTime;
                }

                // Переходим к следующему дню
                $currentDate->addDay();
            }
        }

        $this->command->info('Сеансы успешно созданы.');
    }
}