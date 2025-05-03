<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatPrice extends Model
{
    use HasFactory;

    protected $fillable = ['hall_id', 'seat_type', 'price'];

    // Зависимость с таблицей cinema_halls
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class, 'hall_id');
    }

    // Связь с местами (обратная связь)
    public function seats()
    {
        return $this->hasMany(Seat::class, 'type', 'seat_type')
            ->where('hall_id', $this->hall_id);
    }

}