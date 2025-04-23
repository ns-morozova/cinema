<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovieSession;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.index');
    }

    public function hall()
    {
        return view('client.hall');
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

            // Получаем все сеансы за указанную дату
            $sessions = MovieSession::with(['movie', 'cinemaHall'])
                ->whereBetween('start_time', [$startOfDay, $endOfDay])
                ->get()
                ->groupBy('movie_id');

            // Формируем массив данных для отображения
            $moviesData = [];
            foreach ($sessions as $movieId => $movieSessions) {
                $movie = $movieSessions->first()->movie;
                $seances = [];

                foreach ($movieSessions as $session) {
                    $hallName = $session->cinemaHall->name;
                    $startTime = Carbon::parse($session->start_time)->format('H:i');
                    if (!isset($seances[$hallName])) {
                        $seances[$hallName] = [];
                    }
                    $seances[$hallName][] = $startTime;
                }

                $moviesData[] = [
                    'id' => $movie->id,
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
