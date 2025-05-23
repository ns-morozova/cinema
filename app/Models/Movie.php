<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'duration', 'price_vip', 'price_regular', 'poster', 'color'];

    // Фильм может быть во многих сеансах
    public function movieSessions()
    {
        return $this->hasMany(MovieSession::class, 'movie_id');
    }

    // Удаление фильма и связанных сеансов
    public function destroyMovie($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->movieSessions()->delete();
        $movie->delete();

        return redirect()->route('admin.index')->with('success', 'Фильм и его сеансы удалены.');
    }
}