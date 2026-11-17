<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SavedReceiverController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StaffAuthController;

// Staff Login and Logout
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
// Only authorized staff can access these routes
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
});