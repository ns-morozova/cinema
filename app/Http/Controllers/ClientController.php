<?php

namespace App\Http\Controllers;

use App\Models\SeatPrice;
use Illuminate\Http\Request;
use App\Models\MovieSession;
use Carbon\Carbon;
use App\Models\CinemaHall;
use App\Models\Ticket;
use App\Models\Seat;
use Vtiful\Kernel\Format;

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
            //$hall = CinemaHall::findOrFail($hallId)->seatprices;
            $hall = CinemaHall::with('seatPrices')->findOrFail($hallId);

            // Извлекаем цены для vip и standart
            $prices = $hall->seatPrices->pluck('price', 'seat_type');
            $vipPrice = $prices['vip'] ?? 0; // Цена для VIP-мест
            $standartPrice = $prices['standart'] ?? 0; // Цена для стандартных мест

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
                    return [$ticket->seat_id => $ticket];
                });
            }

            // Передаем данные в шаблон
            return view('client.hall', [
                'date' => $date,
                'time' => $time,
                'hall' => $hall,
                'seats' => $seats,
                'tickets' => $tickets,
                'vip_price' => $vipPrice,
                'standart_price' => $standartPrice,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('client.index')->with('error', 'Произошла ошибка при загрузке зала.');
        }
    }

    public function payment(Request $request)
    {
        try {
            // Получаем ID билетов из сессии
            $ticketIds = session('booked_ticket_ids', []);
    
            if (empty($ticketIds)) {
                return redirect()->route('client.index')->with('error', 'Данные о бронировании не найдены.');
            }
            // Загружаем билеты с отношениями
            $tickets = Ticket::with(['session.movie', 'session.cinemaHall'])
                ->whereIn('id', $ticketIds)
                ->get();
    
            if ($tickets->isEmpty()) {
                return redirect()->route('client.index')->with('error', 'Билеты не найдены.');
            }
    
            // Все билеты принадлежат одному сеансу, поэтому берем данные первого билета
            $firstTicket = $tickets->first();
            $session = $firstTicket->session;
            $movie = $session->movie;
            $hall = $session->cinemaHall;
    
            // Формируем данные для view
            $data = [
                'movie_title' => $movie->title,
                'hall_name' => $hall->name,
                'start_time' => $session->start_time,
                'seats' => $tickets->map(function ($ticket) {
                    return [
                        'row' => $ticket->seat->row,
                        'seat' => $ticket->seat->seat,
                        'type' => $ticket->seat->type->value, // Тип места
                        'price' => $ticket->seat->price?->price ?? 0, // Цена из таблицы seat_prices
                    ];
                }),
                'total_cost' => $tickets->sum(function ($ticket) {
                    return $ticket->seat->price?->price ?? 0; // Сумма цен билетов
                }),
            ];
            
            return view('client.payment', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->route('client.index')->with('error', 'Произошла ошибка при загрузке данных о билетах.');
        }
    }

    public function reserveTickets(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
                'time' => 'required|string',
                'hall_id' => 'required|exists:cinema_halls,id',
                'seats' => 'required|array',
                'seats.*' => 'exists:seats,id', // Проверяем, что все ID существуют в таблице seats
            ]);

            $date = $validated['date'];
            $time = $validated['time'];
            $hallId = $validated['hall_id'];
            $selectedSeatIds = $validated['seats'];

            // Формируем дату и время начала сеанса
            $start_time = Carbon::createFromFormat('Y-m-d H:i', "$date $time");

            // Находим сеанс
            $session = MovieSession::where('hall_id', $hallId)
                ->whereDate('start_time', $start_time)
                ->first();

            if (!$session) {
                return response()->json(['success' => false, 'message' => 'Сеанс не найден.']);
            }

            // Проверяем, что места свободны
            $existingTickets = Ticket::where('session_id', $session->id)
                ->whereIn('seat_id', $selectedSeatIds) // Используем ID кресел
                ->get()
                ->keyBy('seat_id');

            foreach ($selectedSeatIds as $seatId) {
                if (isset($existingTickets[$seatId])) {
                    return response()->json(['success' => false, 'message' => 'Некоторые места уже заняты.']);
                }
            }

            // Создаем билеты
            $tickets = [];
            foreach ($selectedSeatIds as $seatId) {
                //$seat = Seat::findOrFail($seatId); // Находим место по ID
                $tickets[] = [
                    'session_id' => $session->id,
                    'seat_id' => $seatId,
                    'qr_code' => uniqid('ticket_', true), // Генерация уникального QR-кода
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }


            Ticket::insert($tickets);

            // Получаем ID созданных билетов
            $createdTickets = Ticket::where('session_id', $session->id)
            ->whereIn('seat_id', $selectedSeatIds)->get();

            // Сохраняем ID билетов в сессию
            session(['booked_ticket_ids' => $createdTickets->pluck('id')]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function ticket(Request $request)
    {
        // Получаем данные из POST-запроса
        $data = json_decode($request->input('data'), true);

        // Передаем данные в шаблон
        return view('client.ticket', ['data' => $data]);
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
