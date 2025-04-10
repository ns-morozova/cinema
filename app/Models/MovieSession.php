<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}