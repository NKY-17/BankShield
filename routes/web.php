
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::middleware('auth')->group(function () {

    // Customer chat interface
    Route::get('/support-chat', function () {
        return view('chat');
    })->name('chat.interface');

    // List conversations
    Route::get('/chat', [ChatController::class, 'index'])
        ->name('chat.index');

    // Create conversation
    Route::post('/chat', [ChatController::class, 'store'])
        ->name('chat.store');

    // View conversation
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])
        ->name('chat.show');

    // Retrieve conversation messages
    Route::get('/chat/{conversation}/messages', [ChatController::class, 'messages'])
        ->name('chat.messages');

    // Send message
    Route::post('/chat/{conversation}/messages', [ChatController::class, 'sendMessage'])
        ->name('chat.messages.send');

    // Resolve conversation
    Route::post('/chat/{conversation}/resolve', [ChatController::class, 'resolve'])
        ->name('chat.resolve');

});
