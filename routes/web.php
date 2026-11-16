
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TransactionHistoryController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// =====================================
// F19 - Transaction History
// Public sample-data page for development
// =====================================

Route::get('/transactions', [TransactionHistoryController::class, 'index'])
    ->name('transactions.index');

// =====================================
// F16 - Live Support Chat
// Keep existing chat routes protected
// =====================================

Route::middleware('auth')->group(function () {

    Route::get('/support-chat', function () {
        return view('chat');
    })->name('chat.interface');

    Route::get('/chat', [ChatController::class, 'index'])
        ->name('chat.index');

    Route::post('/chat', [ChatController::class, 'store'])
        ->name('chat.store');

    Route::get('/chat/{conversation}', [ChatController::class, 'show'])
        ->name('chat.show');

    Route::get('/chat/{conversation}/messages', [ChatController::class, 'messages'])
        ->name('chat.messages');

    Route::post('/chat/{conversation}/messages', [ChatController::class, 'sendMessage'])
        ->name('chat.messages.send');

    Route::post('/chat/{conversation}/resolve', [ChatController::class, 'resolve'])
        ->name('chat.resolve');

});
