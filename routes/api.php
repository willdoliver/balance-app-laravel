<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BalanceController;

// TODO: add middleware
Route::post('/reset', [BalanceController::class, 'reset']);
Route::get('/balance', [BalanceController::class, 'balance']);
Route::post('/event', [BalanceController::class, 'event']);
