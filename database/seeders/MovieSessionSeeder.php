<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\CinemaHall;
use App\Models\MovieSession;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MovieSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::all();
        $halls = CinemaHall::all();

        if ($movies->isEmpty() || $halls->isEmpty()) {
            $this->command->warn('Нет фильмов или залов для создания сеансов.');
            return;
        }

        $startDate = Carbon::today();

        for ($day = 0; $day < 14; $day++) {
            $currentDate = $startDate->copy()->addDays($day);

            foreach ($halls as $hall) {
                $sessionStart = $currentDate->copy()->setTime(9, 0); // 9:00 утра

                for ($i = 0; $i < 3; $i++) {
                    $movie = $movies->random();
                    $duration = $movie->duration;

                    $sessionEnd = $sessionStart->copy()->addMinutes($duration);

                    MovieSession::create([
                        'movie_id' => $movie->id,
                        'hall_id' => $hall->id,
                        'start_time' => $sessionStart,
                        'end_time' => $sessionEnd,
                    ]);

                    // Добавляем 30 минут на перерыв
                    $sessionStart = $sessionEnd->copy()->addMinutes(30);
                }
            }
        }

        $this->command->info('Сеансы успешно созданы.');
    }
}
