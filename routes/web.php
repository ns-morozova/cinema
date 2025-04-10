<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;

// Route::get('/', function () {
//     return view('client.index');
// });

// Route::get('/hall', function () {
//     return view('client.hall');
// });

// Route::get('/payment', function () {
//     return view('client.payment');
// });

// Route::get('/ticket', function () {
//     return view('client.ticket');
// });

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

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.index');
    
require __DIR__.'/auth.php';
