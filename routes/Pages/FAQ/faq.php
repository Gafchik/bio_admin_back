<?php

use App\Http\Controllers\FAQ\FaqController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'faq',],
    function () {
        Route::post('/get', [FaqController::class, 'getFaq']);
        Route::post('/get-category', [FaqController::class, 'getFaqCategory']);
        Route::post('/get-question', [FaqController::class, 'getFaqQuestion']);
        Route::post('/change-category', [FaqController::class, 'changeCategory']);
        Route::post('/add-category', [FaqController::class, 'addCategory']);
        Route::post('/delete-category', [FaqController::class, 'deleteCategory']);

        Route::post('/change-faq', [FaqController::class, 'changeFaq']);
        Route::post('/add-faq', [FaqController::class, 'addFaq']);
        Route::post('/delete-faq', [FaqController::class, 'deleteFaq']);
    }
);
