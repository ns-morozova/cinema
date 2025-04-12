<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CinemaHall;

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

        $data = [
            'halls' => $halls,
            'selectedHall' => $selectedHall,
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

        return response()->json([
            'rows' => $hall->rows,
            'seats_per_row' => $hall->seats_per_row,
            'layout' => $layout,
        ]);
    }
}