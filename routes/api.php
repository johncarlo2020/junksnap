<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ApplicationController;




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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('get', [UserController::class, 'user']);
        Route::post('edit', [UserController::class, 'EditProfile']);
    });

    Route::group(['prefix' => 'application'], function () {
        Route::post('submit', [ApplicationController::class, 'submit']);
    });

    Route::group(['prefix' => 'collection'], function () {
        Route::get('get', [CollectionController::class, 'get']);
        Route::post('add', [CollectionController::class, 'add']);
        Route::post('enRoute', [CollectionController::class, 'enRoute']);
        Route::post('grab', [CollectionController::class, 'grab']);
        Route::post('cancel', [CollectionController::class, 'cancel']);

        Route::get('collectorSuccess', [CollectionController::class, 'collectorSuccess']);
        Route::get('collectorCancel', [CollectionController::class, 'collectorCancel']);
        Route::get('sellerSuccess', [CollectionController::class, 'sellerSuccess']);
        Route::get('sellerCancel', [CollectionController::class, 'sellerCancel']);
    });
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/test', [AuthController::class, 'test']);
