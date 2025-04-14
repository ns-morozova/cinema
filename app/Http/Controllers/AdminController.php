<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CinemaHall;
use App\Models\SeatPrice;
use App\Models\Movie;
use App\Models\MovieSession;

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
          ['hall_id' => $hallId, 'seat_type' => 'vip'],
          ['price' => $validated['vip']]
      );

      SeatPrice::updateOrCreate(
          ['hall_id' => $hallId, 'seat_type' => 'standart'],
          ['price' => $validated['standart']]
      );

      return response()->json(['message' => 'Цены успешно обновлены']);
  }    
}