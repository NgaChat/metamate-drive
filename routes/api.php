<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\AuthController;
use App\Models\Ads;

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

Route::post('/login', [AuthController::class, 'login']);

Route::get('/login', function () {
    return 'hello';
});

Route::get('/drives/{id}', [DriveController::class, 'show']);
//done
Route::get('/ads/{user_id}', [AdsController::class, 'show']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/drives', [DriveController::class, 'index']);
    Route::put('/drives/{id}', [DriveController::class, 'update']);
    Route::post('/drives', [DriveController::class, 'store']);
    Route::delete('/drives/{id}', [DriveController::class, 'destroy']);

    Route::post('/ads', [AdsController::class, 'store']);
    Route::delete('/ads/{id}', [AdsController::class, 'destroy']);
    Route::put('/ads/{id}', [AdsController::class, 'update']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
