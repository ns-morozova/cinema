<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SeatType;
use App\Models\Ticket;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['hall_id', 'row', 'seat', 'type'];
    protected $casts = [
        'type' => SeatType::class,
    ];

    // Место принадлежит залу
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class, 'hall_id');
    }

// Связь с билетом (обратная связь "один к одному")
public function ticket()
{
    return $this->hasOne(Ticket::class, 'seat_id');
}

}