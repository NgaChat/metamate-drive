<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\AuthController;


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

Route::get('/drives/slug/{slug}', [DriveController::class, 'show']);

Route::post('/add-down-count/{id}', [DriveController::class, 'update_down_count']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::controller(DriveController::class)->group(function () {
        Route::get('/drives', 'index');
        Route::put('/drives/{id}', 'update');
        Route::post('/drives', 'store');
        Route::delete('/drives/{id}', 'destroy');
    });

    Route::controller(AdsController::class)->group(function () {
        Route::get('/ads',  'index');
        Route::post('/ads',  'store');
        Route::delete('/ads/{id}',  'destroy');
        Route::put('/ads/{id}',  'update');
    });

    Route::get('/current-user', function () {
        return auth()->user();
    });
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
