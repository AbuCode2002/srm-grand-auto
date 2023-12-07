<?php

use App\Http\Controllers\Admin\Application\ApplicationController;
use App\Http\Controllers\Admin\Car\CarController;
use App\Http\Controllers\Admin\CarStatistic\CarStatisticController;
use App\Http\Controllers\Admin\Client\ClientController;
use App\Http\Controllers\Admin\Contract\ContractController;
use App\Http\Controllers\Admin\DefectiveAct\DefectiveActController;
use App\Http\Controllers\Admin\Driver\DriverController;
use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Region\RegionController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\ServiceName\ServiceNameController;
use App\Http\Controllers\Admin\Station\StationController;
use App\Http\Controllers\Admin\User\UserController;
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
            Route::get('/parent-region/{id}', [RegionController::class, 'indexParentRegion'])
                ->where('id', '[0-9]+');
        });

        Route::get('/driver', [DriverController::class, 'index']);

        Route::group(['prefix' => 'defective-act'], static function () {
            Route::post('/{orderId}', [DefectiveActController::class, 'store'])
                ->where('orderId', '[0-9]+');
        });

        Route::group(['prefix' => 'car'], static function () {
            Route::get('/', [CarController::class, 'index']);
            Route::get('/{id}', [CarController::class, 'show'])
                ->where('id', '[0-9]+');
            Route::get('/name', [CarController::class, 'carName']);
            Route::get('/statistic', [CarController::class, 'statistic']);
        });

        Route::get('/user', [UserController::class, 'show']);
        Route::get('/all-manager', [UserController::class, 'allManager']);
        Route::get('/client', [ClientController::class, 'index']);
        Route::get('/station/{regionId}/{orderId}', [StationController::class, 'show'])
            ->where('regionId', '[0-9]+')
            ->where('orderId', '[0-9]+');

        Route::group(['prefix' => 'statistic'], static function () {
            Route::post('/car-statistic', [CarStatisticController::class, 'sumDefectiveActWorkForCar']);
            Route::post('/kpi', [CarStatisticController::class, 'KPI']);
        });
    });

});
