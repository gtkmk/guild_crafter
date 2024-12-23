<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::get('/players', [PlayerController::class, 'index'])->name('players.index');

Route::get('/', function () {
    return "kkkkkkkkkkkkkkk";
});
