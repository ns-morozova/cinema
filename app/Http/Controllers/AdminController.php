<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\CinemaHall;

class AdminController extends Controller
{
    public function index()
    {

        $halls = CinemaHall::all()->map(function ($hall) {
            return [
                'id' => $hall->id,
                'name' => $hall->name,
                'rows' => $hall->rows,
                'seats_per_row' => $hall->seats_per_row,
            ];
        })->toArray();

        //$halls = CinemaHall::pluck('name')->toArray();

        $data = [
            'halls' => $halls,
        ];

        return view('admin.index', $data);
    }
}