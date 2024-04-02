<?php

use App\Http\Controllers\News\NewsController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => [],
        'prefix' => 'news',
    ],
    function () {
        Route::post('/get-items', [NewsController::class, 'getItems']);
        Route::post('/edit', [NewsController::class, 'edit']);
        Route::post('/delete', [NewsController::class, 'delete']);
        Route::post('/add', [NewsController::class, 'add']);
    }
);
