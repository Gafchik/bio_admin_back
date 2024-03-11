<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

//Route::post('/login', [AuthController::class, 'login']);
//Route::post('/logout', [AuthController::class, 'logout']);
//Route::post('/google2fac', [AuthController::class, 'google2fac']);

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
//    Route::post('register', 'register');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/google2fac', 'google2fac')->name('google2fac');
});
