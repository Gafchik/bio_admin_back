<?php

use App\Http\Controllers\Gallery\GalleryController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => [],
        'prefix' => 'gallery',
    ],
    function () {
        Route::post('/get-items', [GalleryController::class, 'getItems'])
            ->middleware('checkRoles:' . implode(',', [
                    'gallery.create',
                    'gallery.read',
                    'gallery.write',
                    'gallery.delete',
                ]));
        Route::post('/get-items-album', [GalleryController::class, 'getItemsAlbum'])
            ->middleware('checkRoles:' . implode(',', [
                    'gallery.create',
                    'gallery.read',
                    'gallery.write',
                    'gallery.delete',
                ]));
        Route::post('/edit-items-album', [GalleryController::class, 'editItemsAlbum'])
            ->middleware('checkRoles:' . implode(',', [
                    'gallery.write',
                ]));
        Route::post('/add-items-album', [GalleryController::class, 'addItemsAlbum'])
            ->middleware('checkRoles:' . implode(',', [
                    'gallery.create',
                ]));
        Route::post('/delete-items-album', [GalleryController::class, 'deleteItemsAlbum'])
            ->middleware('checkRoles:' . implode(',', [
                    'gallery.delete',
                ]));
    }
);
