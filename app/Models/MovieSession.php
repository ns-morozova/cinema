<?php

namespace App\Models;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CinemaHall;

class MovieSession extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id', 'hall_id', 'start_time', 'end_time'];

    // Сеанс принадлежит фильму
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    // Сеанс принадлежит кинозалу
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class, 'hall_id');
    }

    // Сеанс имеет много билетов
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'session_id');
    }

    public function getSessionsByDate(Request $request)
    {
        $date = $request->input('date');

        $halls = CinemaHall::all();
        $movieSessions = MovieSession::with('movie')
            ->whereDate('start_time', $date)
            ->get()
            ->groupBy('hall_id');

        return response()->json([
            'html' => view('admin.session-timeline', compact('halls', 'movieSessions', 'date'))->render(),
        ]);
    }
}