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
        Route::post('/get-items-album', [GalleryController::class, 'getItemsAlbum']);
        Route::post('/edit-items-album', [GalleryController::class, 'editItemsAlbum']);
        Route::post('/add-items-album', [GalleryController::class, 'addItemsAlbum']);
        Route::post('/delete-items-album', [GalleryController::class, 'deleteItemsAlbum']);
    }
);
