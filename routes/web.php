<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\MovieSession;

Route::controller(ClientController::class)->group(function () {
    Route::get('/', 'index')->name('client.index');
    Route::get('/hall', 'hall')->name('client.hall');
    Route::get('/payment', 'payment')->name('client.payment');
    Route::post('/ticket', 'ticket')->name('client.ticket');
    Route::post('/reserve-tickets', 'reserveTickets')->name('client.reserveTickets');

    Route::post('client/sessions/by-date', 'getSessionsByDate')->name('client.sessions.byDate');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Группа маршрутов с префиксом /admin и middleware auth, verified
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    // Роут для главной страницы админ-панели
    Route::get('/', [AdminController::class, 'index'])
        ->name('admin.index');

    // Роут для получения данных о зале через AJAX
    Route::post('/get-hall-data', [AdminController::class, 'getHallData'])
        ->name('admin.getHallData');

    Route::post('/update-hall-layout', [AdminController::class, 'updateHallLayout'])
        ->name('admin.updateHallLayout');

    Route::post('/update-hall-price', [AdminController::class, 'updateHallPrice'])
        ->name('admin.updateHallPrice');

    Route::post('/cinema-halls/store', [CinemaHall::class, 'store'])
        ->name('admin.cinema-halls.store');

    Route::delete('/cinema-halls/{id}', [CinemaHall::class, 'destroyHall'])
        ->name('admin.cinema-halls.destroy');

    Route::post('/sessions/by-date', [AdminController::class, 'getSessionsByDate'])
        ->name('admin.sessions.byDate');

    Route::post('/movies/store', [AdminController::class, 'storeMovie'])
        ->name('admin.movies.store');

    Route::delete('/movies/{id}', [Movie::class, 'destroyMovie'])
        ->name('admin.movies.destroy');

    Route::post('/sessions/store', [AdminController::class, 'storeSession'])
        ->name('admin.sessions.store');

    Route::delete('/sessions/{id}', [MovieSession::class, 'destroySession'])
        ->name('admin.sessions.destroy');

    Route::post('/halls/{id}/toggle-enabled', [CinemaHall::class, 'toggleEnabled'])
        ->name('admin.halls.toggleEnabled');
});

    
require __DIR__.'/auth.php';
