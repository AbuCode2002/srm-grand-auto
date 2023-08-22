<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\Application\ApplicationController;
use App\Http\Controllers\Client\Contract\ContractController;
use App\Http\Controllers\Client\Order\OrderController;
use Illuminate\Http\Request;
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
Route::group(['prefix' => 'auth'], static function()
{
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'client'], static function () {
    Route::group(['prefix' => 'order'], static function () {
        Route::post('/', [OrderController::class, 'store']);
    });

    Route::get('/application', [ApplicationController::class, 'index']);
    Route::get('/contract', [ContractController::class, 'index']);
});
