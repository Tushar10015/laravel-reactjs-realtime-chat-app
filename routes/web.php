<?php

use App\Events\MessageSent;
use App\Http\Controllers\ProfileController;
use App\Models\Message;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/send-message', function () {
    broadcast(new MessageSent(Message::create(['user_id' => 1, 'message_content' => 'Hello from Laravel!'])));
    return 'Message sent!';
});

Route::get('/chat', function () {
    return view('chat');
})->middleware(['auth', 'verified'])->name('chat');

require __DIR__ . '/auth.php';
