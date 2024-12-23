<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');

Route::get('/', function () {
    return "kkkkkkkkkkkkkkk";
});
