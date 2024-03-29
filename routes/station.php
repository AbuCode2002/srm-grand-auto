<?php

use App\Http\Controllers\Station\Application\ApplicationController;
use App\Http\Controllers\Station\Car\CarController;
use App\Http\Controllers\Station\Client\ClientController;
use App\Http\Controllers\Station\Contract\ContractController;
use App\Http\Controllers\Station\DefectiveAct\DefectiveActController;
use App\Http\Controllers\Station\Diagnostics\DiagnosticsController;
use App\Http\Controllers\Station\Driver\DriverController;
use App\Http\Controllers\Station\FileUpload\FileUploadController;
use App\Http\Controllers\Station\Order\OrderController;
use App\Http\Controllers\Station\Region\RegionController;
use App\Http\Controllers\Station\Role\RoleController;
use App\Http\Controllers\Station\ServiceName\ServiceNameController;
use App\Http\Controllers\Station\Station\StationController;
use App\Http\Controllers\Station\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'role'], static function () {
    Route::get('/', [RoleController::class, 'index']);
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::group(['prefix' => 'order'], static function () {

            Route::post('/', [OrderController::class, 'store']);

            Route::post('/edit', [OrderController::class, 'edit']);

            Route::get('/', [OrderController::class, 'index']);

            Route::get('/show/{id}', [OrderController::class, 'show'])
                ->where('id', '[0-9]+');

            Route::get('/index-by-status', [OrderController::class, 'indexByStatus']);

            Route::post('/change-status/{id}', [OrderController::class, 'changeStatus'])
                ->where('id', '[0-9]+');

            Route::post('/paid-status/{id}', [OrderController::class, 'paidStatus'])
                ->where('id', '[0-9]+');

            Route::post('/end-status/{id}', [OrderController::class, 'endWork'])
                ->where('id', '[0-9]+');

        });

        Route::group(['prefix' => 'role'], static function () {
            Route::get('/', [RoleController::class, 'index']);
        });

        Route::get('/service-name', [ServiceNameController::class, 'index']);

        Route::get('/application', [ApplicationController::class, 'index']);

        Route::get('/contract', [ContractController::class, 'index']);

        Route::group(['prefix' => 'region'], static function () {
            Route::get('/', [RegionController::class, 'index']);
            Route::get('/show/{id}', [RegionController::class, 'show'])
                ->where('id', '[0-9]+');
        });

        Route::get('/driver', [DriverController::class, 'index']);

        Route::group(['prefix' => 'defective-act'], static function () {
            Route::post('/{orderId}', [DefectiveActController::class, 'store'])
                ->where('orderId', '[0-9]+');
            Route::get('/', [DefectiveActController::class, 'index']);
            Route::get('/show/{orderId}', [DefectiveActController::class, 'show']);
        });

        Route::group(['prefix' => 'car'], static function () {
            Route::get('/', [CarController::class, 'index']);
            Route::get('/{id}', [CarController::class, 'show'])
                ->where('id', '[0-9]+');
        });

        Route::get('/user', [UserController::class, 'show']);

        Route::get('/client', [ClientController::class, 'index']);

        Route::get('/station/{regionId}/{orderId}', [StationController::class, 'show'])
            ->where('regionId', '[0-9]+')
            ->where('orderId', '[0-9]+');

        Route::post('/diagnostics/{orderId}', [DiagnosticsController::class, 'store']);


        Route::post('/upload-video/{orderId}', [FileUploadController::class, 'upload'])
            ->where('orderId', '[0-9]+');
    });
});
