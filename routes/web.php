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
// Default route
Route::get('/', function () {
    return view('welcome');
});

// Test route with authentication and 'test' middleware
Route::get('/test', function () {
    return view('home');
})->middleware(['auth', 'login'])->name('home.test');

// Pages route (example)
Route::get('/pages', function () {
    return view('home');
});

// Login page route
Route::get('/login', function () {
    return view('auth.login');
})->name('login');  // Named route for login page

// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    // Add other authenticated routes here if needed
    // For example:
    Route::get('/test', [AuthController::class, 'login'])->name('home.test');
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function () {
//     return view('home');
// })->middleware(['auth','test'])->name('test');

// Route::get('/pages', function () {
//     return view('home');
// });

// Route::get('/login', function () {
//     return view('auth.login');
// });

// Route::middleware('auth')->group(function () {
//     // Login route (POST request)
//     Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
// });

// // For authenticated users
// Route::middleware('auth')->group(function () {
//     // Test route (GET request) for authenticated users
//     Route::get('/test', [AuthController::class, 'test'])->name('home.test');
// });
// Route::get('/pages', function () {
//     return view('home');
// });

// Route::get('/login', function () {
//     return view('auth.login');
// });
// Route::get('/test', function () {
//     return view('home');
// });
// // Route::post('/login','AuthController@login');

//   Route::middleware('auth')->group(function () {
//       Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
//  });

//  Route::middleware('auth')->group(function () {
//     Route::get('/test', [AuthController::class, 'test'])->name('home.test');
//  });
//  Route::group(['middleware' => 'web'], function () {
//     Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
// });
//Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
//Route::post('/login', 'AuthController@login')->middleware('web');
