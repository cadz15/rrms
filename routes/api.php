<?php

use App\Http\Controllers\Api\MobileAppController;
use App\Http\Controllers\Api\RequestApiController;
use App\Http\Controllers\Api\RequestorAuthApiController;
use App\Http\Controllers\Api\StudentApiController;
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
Route::prefix('v1')->group(function () {
    Route::prefix('requestor')->group(function () {
        Route::post('login', [RequestorAuthApiController::class, 'login']);
        Route::post('register', [StudentApiController::class, 'store']);

        Route::middleware('api')->group(function () {
            Route::apiResource('requests', RequestApiController::class);
        });
    });
});


Route::group(['prefix' => 'v2'], function() {
    Route::post('login', [MobileAppController::class, 'login']);
    Route::post('refresh', [MobileAppController::class,'refresh']);
    Route::post('logout', [MobileAppController::class, 'logout']);
    Route::post('profile', [MobileAppController::class, 'profile']);
    Route::put('update-user', [MobileAppController::class, 'updateUser']);
    Route::post('update-password', [MobileAppController::class, 'updatePassword']);
    Route::post('requests', [MobileAppController::class,'requests']);
    Route::post('cancel-request', [MobileAppController::class, 'cancelRequest']);
    Route::post('requestable-items', [MobileAppController::class,'requestableItems']);
    Route::post('create-request', [MobileAppController::class, 'createRequest']);
});
