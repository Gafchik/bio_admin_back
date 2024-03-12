<?php

use App\Http\Controllers\FAQ\FaqController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'faq',],
    function () {
        Route::post('/', [FaqController::class, 'getFaq']);
    }
);
