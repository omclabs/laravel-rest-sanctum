<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
  Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
      Route::post('logout', [AuthController::class, 'logout']);
    });
  });

  Route::group(['prefix' => 'transaction', 'middleware' => 'auth:sanctum; throttle:2,1'], function () {
    Route::post('/', [TransactionController::class, 'store']);
  });

  Route::get('/quote', [QuoteController::class, 'index']);
});
