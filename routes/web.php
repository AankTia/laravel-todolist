<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\OnlyGuestMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/template', 'template');

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'login')->middleware(OnlyGuestMiddleware::class);
    Route::post('/login', 'doLogin')->middleware(OnlyGuestMiddleware::class);
    Route::post('/logout', 'doLogout');
});
