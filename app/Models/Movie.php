<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'duration', 'price_vip', 'price_regular', 'poster'];

    // Фильм может быть во многих сеансах.
    public function movieSessions()
    {
        return $this->hasMany(MovieSession::class, 'movie_id');
    }
}