<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Enums\SeatType;

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

    // Зал имеет много мест
    public function seats()
    {
        return $this->hasMany(Seat::class, 'hall_id');
    }    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);
    
        // Создаем зал
        $hall = CinemaHall::create($validated);
    
        // Генерируем места для зала
        $seats = [];
        for ($row = 1; $row <= $hall->rows; $row++) {
            for ($seat = 1; $seat <= $hall->seats_per_row; $seat++) {
                $type = ($row <= 2) ? SeatType::VIP->value : SeatType::STANDART->value; // Первые два ряда — VIP
                $seats[] = [
                    'hall_id' => $hall->id,
                    'row' => $row,
                    'seat' => $seat,
                    'type' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
    
        // Массовое создание мест
        Seat::insert($seats);

        if ($request->ajax()) {
            return response()->json($hall);
        }
    
        return redirect()->route('admin.index')->with('success', 'Зал успешно создан.');
    }

    public function destroyHall($id)
    {
        $hall = CinemaHall::findOrFail($id);

        // Удаляем связанные места
        $hall->seats()->delete();

        // Удаляем сам зал
        $hall->delete();

        return redirect()->route('admin.index')->with('success', 'Зал успешно удалён.');
    }

    // Зал имеет много цен
    public function seatPrices()
    {
        return $this->hasMany(SeatPrice::class, 'hall_id');
    }    

}