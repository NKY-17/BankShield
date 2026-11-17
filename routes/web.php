<?php

use App\Http\Controllers\SavedReceiverController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('saved-receivers', SavedReceiverController::class)
    ->except(['show']);
