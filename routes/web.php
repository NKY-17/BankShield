<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FraudProtectionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\SavedReceiverController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\FixedDepositController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// F19 - Transaction History
Route::get('/transactions', [TransactionHistoryController::class, 'index'])
    ->name('transactions.index');

// F16 - Live Support Chat
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

// Central Login and Logout
Route::get('/staff/login', [StaffAuthController::class, 'showLogin'])
    ->name('login');

Route::post('/staff/login', [StaffAuthController::class, 'login'])
    ->name('login.submit');

Route::post('/staff/logout', [StaffAuthController::class, 'logout'])
    ->name('logout');

// Saved Receiver Routes
Route::resource('saved-receivers', SavedReceiverController::class)
    ->except(['show']);

// Customer and Account Management
// Admin and Staff access
Route::middleware('staff')->group(function () {

    // Customer Routes
    Route::get('/customers', [CustomerController::class, 'index'])
        ->name('customers.index');

    Route::get('/customers/create', [CustomerController::class, 'create'])
        ->name('customers.create');

    Route::post('/customers', [CustomerController::class, 'store'])
        ->name('customers.store');

    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
        ->name('customers.edit');

    Route::put('/customers/{customer}', [CustomerController::class, 'update'])
        ->name('customers.update');

    Route::get('/customers/search', [CustomerController::class, 'search'])
        ->name('customers.search');

    // Account Routes
    Route::get('/accounts', [AccountController::class, 'index'])
        ->name('accounts.index');

    Route::get('/accounts/create', [AccountController::class, 'create'])
        ->name('accounts.create');

    Route::post('/accounts', [AccountController::class, 'store'])
        ->name('accounts.store');

    Route::patch('/accounts/{account}/freeze', [AccountController::class, 'freeze'])
        ->name('accounts.freeze');

    Route::patch('/accounts/{account}/unfreeze', [AccountController::class, 'unfreeze'])
        ->name('accounts.unfreeze');

    Route::patch('/accounts/{account}/close', [AccountController::class, 'close'])
        ->name('accounts.close');

    // Fraud Protection and Case Board
    Route::post('/fraud/check', [FraudProtectionController::class, 'checkTransaction'])
        ->name('fraud.check');

    Route::get('/fraud/cases', [FraudProtectionController::class, 'index'])
        ->name('fraud.board');

    Route::patch('/fraud/cases/{fraudCase}', [FraudProtectionController::class, 'updateCase'])
        ->name('fraud.cases.update');

    Route::get('/fraud/dashboard', [FraudProtectionController::class, 'dashboard'])
        ->name('fraud.dashboard');

    Route::post('/accounts/check-fraud', [AccountController::class, 'checkFraud'])
        ->name('accounts.check-fraud');
});

// Fixed Deposit Routes
// Customers can access only their own deposits
Route::middleware('customer')->group(function () {

    Route::get('/fixed-deposits', [FixedDepositController::class, 'index'])
        ->name('fixed-deposits.index');

    Route::get('/fixed-deposits/create', [FixedDepositController::class, 'create'])
        ->name('fixed-deposits.create');

    Route::post('/fixed-deposits', [FixedDepositController::class, 'store'])
        ->name('fixed-deposits.store');
});

// Fraud Verification Routes
Route::get('/fraud/verify/{token}', [FraudProtectionController::class, 'showVerification'])
    ->name('fraud.verify.show');

Route::post('/fraud/verify/{token}', [FraudProtectionController::class, 'verifyTransaction'])
    ->name('fraud.verify.submit');
