<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CinemaHall;
use App\Models\SeatPrice;
use App\Models\Movie;
use App\Models\MovieSession;
use Carbon\Carbon;
use App\Enums\SeatType;

class AdminController extends Controller
{
    // Главная страница админ-панели
    public function index(Request $request)
    {
        $halls = CinemaHall::all()->map(function ($hall) {
            return [
                'id' => $hall->id,
                'name' => $hall->name,
                'rows' => $hall->rows,
                'seats_per_row' => $hall->seats_per_row,
                'enabled' => $hall->enabled,
            ];
        })->toArray();

        // Получаем выбранный зал из GET-параметра
        $selectedHallId = $request->input('hall_id');
        $selectedHall = null;

        if ($selectedHallId) {
            $selectedHall = CinemaHall::find($selectedHallId);
        }

        // Если зал не выбран, берем первый зал по умолчанию
        if (!$selectedHall && !empty($halls)) {
            $selectedHall = CinemaHall::find($halls[0]['id']);
        }

        // Получаем все фильмы
        $movies = Movie::all();

        // Получаем все сеансы
        $movieSessions = MovieSession::all();

        $data = [
            'halls' => $halls,
            'selectedHall' => $selectedHall,
            'movies' => $movies,
            'movieSessions' => $movieSessions,
        ];

        return view('admin.index', $data);
    }

    // Получение данных о зале через AJAX
    public function getHallData(Request $request)
    {
        $hallId = $request->input('hall_id');
        $hall = CinemaHall::with('seats')->find($hallId);

        if (!$hall) {
            return response()->json(['error' => 'Зал не найден'], 404);
        }

        // Формируем план зала
        $layout = [];
        foreach ($hall->seats->groupBy('row') as $rowNumber => $seatsInRow) {
            $row = [];
            foreach ($seatsInRow as $seat) {
                $row[] = $seat->type; // Тип места: vip, standart или disabled
            }
            $layout[] = $row;
        }

        // Формируем цены
        $prices = $hall->seatPrices->pluck('price', 'seat_type');
        $prices['vip'] = $prices['vip'] ?? 0;
        $prices['standart'] = $prices['standart'] ?? 0;

        return response()->json([
            'rows' => $hall->rows,
            'seats_per_row' => $hall->seats_per_row,
            'layout' => $layout,
            'prices' => $prices,
        ]);
    }

    // Обновление конфигурации зала
    public function updateHallLayout(Request $request)
    {
        $validated = $request->validate([
            'hall_id' => 'required|exists:cinema_halls,id',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
            'layout' => 'required|array',
        ]);

        $hall = CinemaHall::find($validated['hall_id']);
        $hall->update([
            'rows' => $validated['rows'],
            'seats_per_row' => $validated['seats_per_row'],
        ]);

        // Удаляем старые места
        $hall->seats()->delete();

        // Перезаписываем
        $seats = [];
        foreach ($validated['layout'] as $rowIndex => $row) {
            foreach ($row as $seatIndex => $type) {
                $seats[] = [
                    'hall_id' => $hall->id,
                    'row' => $rowIndex + 1,
                    'seat' => $seatIndex + 1,
                    'type' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        \App\Models\Seat::insert($seats);

        return response()->json(['message' => 'Схема успешно сохранена']);
    }

    // Обновление (добавление) цен для текущего зала
    public function updateHallPrice(Request $request)
    {
        $validated = $request->validate([
            'hall_id' => 'required|exists:cinema_halls,id',
            'vip' => 'required|numeric|min:0',
            'standart' => 'required|numeric|min:0',
        ]);

        $hallId = $validated['hall_id'];

        // Обновляем или создаем записи для цен
        SeatPrice::updateOrCreate(
            ['hall_id' => $hallId, 'seat_type' => SeatType::VIP->value],
            ['price' => $validated['vip']]
        );

        SeatPrice::updateOrCreate(
            ['hall_id' => $hallId, 'seat_type' => SeatType::STANDART->value],
            ['price' => $validated['standart']]
        );

        return response()->json(['message' => 'Цены успешно обновлены']);
    }

    // Получение данных о сеансах за выбранный день
    public function getSessionsByDate(Request $request)
    {
        // Получаем дату из тела запроса
        $date = Carbon::parse($request->input('date'));

        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();

        // Логика получения сеансов за указанную дату
        $sessions = MovieSession::with(['movie', 'cinemaHall'])->whereBetween('start_time', [$startOfDay, $endOfDay])->get()->groupBy('hall_id');
    
        return response()->json([
            'sessions' => $sessions,
        ]);
    }
    
    // Добавление фильма
    public function storeMovie(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'country' => 'required|string|max:255',
            'poster' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            'color' => 'required|string|max:7',
        ]);

        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $path = $file->store('images/client', 'public');
            $validated['poster'] = 'storage/' . $path;
        }

        Movie::create($validated);

        return redirect()->route('admin.index')->with('success', 'Фильм успешно создан.');
    }

    // Добавление сеанса
    public function storeSession(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|string|max:10', // формат YYYY-MM-DD
                'time' => 'required|string|max:5', // формат HH:MM
                'movie_id' => 'required|integer|min:1',
                'hall_id' => 'required|integer|min:1',
            ]);

            // Собираем start_time из date и time
            $startTime = Carbon::createFromFormat('Y-m-d H:i', "{$validated['date']} {$validated['time']}");

            // Проверка: есть ли уже сеанс в этом зале в это время
            $exists = MovieSession::where('hall_id', $validated['hall_id'])
                ->where('start_time', $startTime)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'В выбранном зале на это время уже назначен сеанс.',
                ], 422);
            }

            // Получаем продолжительность фильма
            $movie = Movie::findOrFail($validated['movie_id']);
            $duration = $movie->duration;

            // Вычисляем end_time
            $endTime = $startTime->copy()->addMinutes($duration);

            // Создаём сеанс
            MovieSession::create([
                'movie_id' => $validated['movie_id'],
                'hall_id' => $validated['hall_id'],
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Сеанс успешно создан.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}