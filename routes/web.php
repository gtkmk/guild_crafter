<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RpgSessionController;
use Illuminate\Support\Facades\Route;

Route::post('/rpg-sessions', [RpgSessionController::class, 'store'])->name('rpg-sessions.store');
Route::get('/rpg-sessions/create', [RpgSessionController::class, 'create'])->name('rpg-sessions.create');
Route::get('/rpg-sessions', [RpgSessionController::class, 'index'])->name('rpg-sessions.index');

Route::delete('/players/{id}', [PlayerController::class, 'destroy'])->name('players.destroy');
Route::put('/players/{id}', [PlayerController::class, 'update'])->name('players.update');
Route::get('/players/{id}/edit', [PlayerController::class,'edit'])->name(name: 'players.edit');
Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');

Route::get('/', [PlayerController::class, 'index'])->name('players.index');

