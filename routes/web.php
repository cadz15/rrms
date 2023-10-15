<?php

use App\Http\Controllers\Web\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    return view('home.test');
})->name('test');


Route::get('/pages', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');  

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::get('/test', [AuthController::class, 'test'])->name('home.test');
});



