<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(WalletController::class)
    ->prefix('wallets')->group(function () {
        Route::get('/', 'list');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
    });
