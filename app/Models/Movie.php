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

    // Добавление фильма
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string|max:255',
    //         'duration' => 'required|integer|min:1',
    //         'country' => 'required|string|max:255',
    //         'poster' => 'required|string|max:255',
    //         'color' => 'required|string|max:255',
    //     ]);

    //     Movie::create($validated);

    //     return redirect()->route('admin.index')->with('success', 'Фильм успешно создан.');
    // }

    // Удаление фильма и связанных сеансов
    public function destroyMovie($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->movieSessions()->delete();
        $movie->delete();

        return redirect()->route('admin.index')->with('success', 'Фильм и его сеансы удалены.');
    }
}