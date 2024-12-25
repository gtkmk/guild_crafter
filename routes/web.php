<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::delete('/players/{id}', [PlayerController::class, 'destroy'])->name('players.destroy');
Route::put('/players/{id}', [PlayerController::class, 'update'])->name('players.update');
Route::get('/players/{id}/edit', [PlayerController::class,'edit'])->name(name: 'players.edit');
Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');

Route::get('/', [PlayerController::class, 'index'])->name('players.index');

