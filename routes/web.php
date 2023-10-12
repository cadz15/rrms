<?php

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
    return view('home');
});

Route::get('/requestor', function() {

    return view('requestor');
});

Route::group(['prefix' => 'requests'], function() {
    Route::get('/', function() {

        return view('requestor.list');
    });

    Route::get('/history/{slug}', function($slug) {
        // we can use id here instead of slug. For this example we use slug for page title and breadcrumbs

        return view('requestor.request-timeline', compact('slug'));
    });
});

Route::group(['prefix' => 'student'], function() {
    Route::get('/information', function() {

        return view('student.information-form');
    });
    Route::get('/create', function() {

        return view('student.information-form');
    });
    Route::get('/list', function() {

        return view('student.list');
    });
});

Route::get('/pages', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('auth.login');
});
