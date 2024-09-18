<?php

use App\Http\Controllers\News\NewsController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => [],
        'prefix' => 'news',
    ],
    function () {
        Route::post('/get-items', [NewsController::class, 'getItems'])
            ->middleware('checkRoles:' . implode(',', [
                    'news.create',
                    'news.read',
                    'news.write',
                    'news.delete',
                ]));
        Route::post('/edit', [NewsController::class, 'edit'])
            ->middleware('checkRoles:' . implode(',', [
                    'news.write',
                ]));
        Route::post('/delete', [NewsController::class, 'delete'])
            ->middleware('checkRoles:' . implode(',', [
                    'news.delete',
                ]));
        Route::post('/add', [NewsController::class, 'add'])
            ->middleware('checkRoles:' . implode(',', [
                    'news.create',
                ]));
    }
);
