<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SeatType;

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
}