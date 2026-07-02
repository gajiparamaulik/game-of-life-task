<?php

use App\Http\Controllers\GameOfLifeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameOfLifeController::class, 'index'])->name('game-of-life.index');
