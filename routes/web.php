<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
Route::get('login' , [AuthController::class, 'loginView'])->name('login');

