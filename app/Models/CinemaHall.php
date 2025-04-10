<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaHall extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rows', 'seats_per_row'];

    protected $table = 'cinema_halls';

    // Кинозал может быть связан с несколькими сеансами
    public function movieSessions()
    {
        return $this->hasMany(MovieSession::class, 'hall_id');
    }
}