<?php

use App\Http\Controllers\Gallery\GalleryController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => [],
        'prefix' => 'gallery',
    ],
    function () {
        Route::post('/get-items', [GalleryController::class, 'getItems']);
//        Route::post('/edit', [NewsController::class, 'edit']);
//        Route::post('/delete', [NewsController::class, 'delete']);
//        Route::post('/add', [NewsController::class, 'add']);
    }
);
