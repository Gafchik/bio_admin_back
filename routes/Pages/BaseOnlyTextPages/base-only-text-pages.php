<?php

use App\Http\Controllers\BaseOnlyTextPages\BaseOnlyTextPagesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'base-only-text-pages',],
    function () {
        Route::post('/get', [BaseOnlyTextPagesController::class, 'get']);

    }
);
