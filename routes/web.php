<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Models\CinemaHall;

Route::controller(ClientController::class)->group(function () {
    Route::get('/', 'index')->name('client.index');
    Route::get('/hall', 'hall')->name('client.hall');
    Route::get('/payment', 'payment')->name('client.payment');
    Route::get('/ticket', 'ticket')->name('client.ticket');
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

    Route::post('/cinema-halls/store', [CinemaHall::class, 'store'])
        ->name('admin.cinema-halls.store');

    Route::delete('/cinema-halls/{id}', [CinemaHall::class, 'destroyHall'])
        ->name('admin.cinema-halls.destroy');

});

    
require __DIR__.'/auth.php';
