<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => [],
    ],
    function () {
        Route::post('/login', [AuthController::class, 'login']);
    }
);
