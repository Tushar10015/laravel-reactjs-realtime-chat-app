<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

//middleware('auth:api')->
Route::post('/messages', [MessageController::class, 'store']);
Route::get('/messages', [MessageController::class, 'index']);
