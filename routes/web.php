<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('welcome');
});

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
// Account Management Routes

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