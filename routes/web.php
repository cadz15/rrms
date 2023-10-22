<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\RequestorController;
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

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'index')->name('login');
        Route::post('login', 'login')->name('auth.login');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('requestors')->controller(RequestorController::class)->group(function () {
        Route::get('/', 'index')->name('requestors.list');
        Route::get('/{student}', 'show')->name('requestors.show');
    });
});

Route::group(['prefix' => 'requests'], function () {
    Route::get('/', function () {

        return view('requests.list');
    });

    Route::get('/history/{slug}', function ($slug) {
        // we can use id here instead of slug. For this example we use slug for page title and breadcrumbs

        return view('requestor.request-timeline', compact('slug'));
    });
});

Route::group(['prefix' => 'student'], function () {
    Route::get('/information', function () {

        return view('student.information-form');
    });
    Route::get('/create', function () {

        return view('student.information-form');
    });
    Route::get('/list', function () {

        return view('student.list');
    });
});

Route::get('/pages', function () {
    return view('home');
});
