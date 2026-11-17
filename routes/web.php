<?php
use App\Http\Controllers\FraudProtectionController;
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
// Fraud Verification Routes
Route::get('/fraud/verify/{token}', [FraudProtectionController::class, 'showVerification'])
    ->name('fraud.verify.show');

Route::post('/fraud/verify/{token}', [FraudProtectionController::class, 'verifyTransaction'])
    ->name('fraud.verify.submit');

// Fraud Protection and Case Board Routes
Route::middleware('staff')->group(function () {

    // Feature 11: Fraud Detection
    Route::post('/fraud/check', [FraudProtectionController::class, 'checkTransaction'])
        ->name('fraud.check');

    // Feature 12: Fraud Case Board
    Route::get('/fraud/cases', [FraudProtectionController::class, 'index'])
        ->name('fraud.board');

    Route::patch('/fraud/cases/{fraudCase}', [FraudProtectionController::class, 'updateCase'])
        ->name('fraud.cases.update');
    // Fraud Protection Dashboard
    Route::get('/fraud/dashboard', [FraudProtectionController::class, 'dashboard'])
        ->name('fraud.dashboard');
    Route::post('/accounts/check-fraud', [AccountController::class, 'checkFraud'])
        ->name('accounts.check-fraud');
});