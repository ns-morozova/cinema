<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovieSession;
use Carbon\Carbon;
use App\Models\CinemaHall;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.index');
    }

    public function hall(Request $request)
    {
        try {
            // Получаем параметры из запроса
            $date = $request->input('date');
            $time = $request->input('time');
            $hallId = $request->input('hall_id');
    
            // Проверяем обязательные параметры
            if (!$date || !$time || !$hallId) {
                return redirect()->route('client.index')->with('error', 'Недостаточно данных для отображения зала.');
            }
    
            // Находим зал по ID
            $hall = CinemaHall::findOrFail($hallId);
    
            // Получаем все места в зале
            $seats = $hall->seats;
    
            // Находим сеанс по дате, времени и залу
            $start_time = Carbon::createFromFormat('Y-m-d H:i', "$date $time");
            $session = MovieSession::where('hall_id', $hallId)
                ->whereDate('start_time', $start_time)
                ->first();
    
            // Получаем билеты для этого сеанса
            $tickets = [];
            if ($session) {
                $tickets = $session->tickets->mapWithKeys(function ($ticket) {
                    return ["{$ticket->row}-{$ticket->seat}" => $ticket];
                });
            }
    
            // Передаем данные в шаблон
            return view('client.hall', [
                'date' => $date,
                'time' => $time,
                'hall' => $hall,
                'seats' => $seats,
                'tickets' => $tickets,
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка при загрузке зала:', ['hall_id' => $hallId, 'error' => $e->getMessage()]);
            return redirect()->route('client.index')->with('error', 'Произошла ошибка при загрузке зала.');
        }
    }

    public function payment()
    {
        return view('client.payment');
    }

    public function ticket()
    {
        return view('client.ticket');
    }

    // Получение данных о сеансах за выбранный день
    public function getSessionsByDate(Request $request)
    {
        try {
            $date = $request->input('date');
            $startOfDay = Carbon::parse($date)->startOfDay();
            $endOfDay = Carbon::parse($date)->endOfDay();


            // Получаем все сеансы за указанную дату, только для залов с enabled = true
            $sessions = MovieSession::with(['movie', 'cinemaHall'])
            ->whereBetween('start_time', [$startOfDay, $endOfDay])
            ->whereHas('cinemaHall', function ($query) {
            $query->where('enabled', true);
            })
            ->get()
            ->groupBy('movie_id');            

            // Формируем массив данных для отображения
            $moviesData = [];
            foreach ($sessions as $movieId => $movieSessions) {
                $movie = $movieSessions->first()->movie;
                $seances = [];

                foreach ($movieSessions as $session) {
                    $hallName = $session->cinemaHall->name;
                    $hallId = $session->cinemaHall->id; // ID зала
                    $startTime = Carbon::parse($session->start_time)->format('H:i');
                    if (!isset($seances[$hallName])) {
                        $seances[$hallName] = [];
                    }
                    //$seances[$hallName][] = $startTime;
                    $seances[$hallName][] = [
                        'time' => $startTime,
                        'hall_id' => $hallId, // Добавляем ID зала
                    ];                    
                }

                $moviesData[] = [
                    'id' => $movie->id,
                    'formattedDate' => $date,
                    'title' => $movie->title,
                    'description' => $movie->description,
                    'duration' => $movie->duration,
                    'country' => $movie->country,
                    'poster' => asset($movie->poster),
                    'seances' => $seances,
                ];
            }

            return response()->json($moviesData);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
}
