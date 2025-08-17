<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn() => ['pong' => true]);

Route::get('/weather', [WeatherController::class, 'index']);