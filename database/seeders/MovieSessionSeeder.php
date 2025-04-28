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

        // Удалим все существующие сеансы перед созданием новых
        MovieSession::truncate();

        $startDate = Carbon::today();

        for ($day = 0; $day < 14; $day++) {
            $currentDate = $startDate->copy()->addDays($day);

            foreach ($halls as $hall) {
                $sessionStart = $currentDate->copy()->setTime(9, 0); // Начало дня

                for ($i = 0; $i < 4; $i++) {
                    $movie = $movies->random();

                    $sessionEnd = $sessionStart->copy()->addMinutes($movie->duration);

                    MovieSession::create([
                        'movie_id' => $movie->id,
                        'hall_id' => $hall->id,
                        'start_time' => $sessionStart,
                        'end_time' => $sessionEnd,
                    ]);

                    // Следующий сеанс — через 3 часа от начала предыдущего
                    $sessionStart = $sessionStart->copy()->addHours(3);
                }
            }
        }

        $this->command->info('Сеансы успешно созданы на 14 дней вперёд.');
    }
}
