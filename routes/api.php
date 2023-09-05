<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\Application\ApplicationController;
use App\Http\Controllers\Client\Car\CarController;
use App\Http\Controllers\Client\Client\ClientController;
use App\Http\Controllers\Client\Contract\ContractController;
use App\Http\Controllers\Client\Driver\DriverController;
use App\Http\Controllers\Client\Order\OrderController;
use App\Http\Controllers\Client\Region\RegionController;
use App\Http\Controllers\Client\Role\RoleController;
use App\Http\Controllers\Client\User\UserController;
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

Route::group(['prefix' => 'role'], static function () {
    Route::get('/', [RoleController::class, 'index']);
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);

    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::group(['prefix' => 'client'], static function () {
            Route::group(['prefix' => 'order'], static function () {
                Route::post('/', [OrderController::class, 'store']);
                Route::get('/', [OrderController::class, 'index']);
                Route::get('/show', [OrderController::class, 'show']);
            });

            Route::group(['prefix' => 'role'], static function () {
                Route::get('/', [RoleController::class, 'index']);
            });

            Route::get('/application', [ApplicationController::class, 'index']);
            Route::get('/contract', [ContractController::class, 'index']);
            Route::get('/region', [RegionController::class, 'index']);
            Route::get('/driver', [DriverController::class, 'index']);
            Route::get('/car', [CarController::class, 'show']);
            Route::get('/user', [UserController::class, 'show']);
            Route::get('/client', [ClientController::class, 'index']);
        });
    });

});
