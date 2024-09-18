<?php

use App\Http\Controllers\FAQ\FaqController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'faq',],
    function () {
        Route::post('/get', [FaqController::class, 'getFaq'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq_category.create',
                    'faq_category.read',
                    'faq_category.write',
                    'faq_category.delete',
                    'faq.create',
                    'faq.read',
                    'faq.write',
                    'faq.delete',
                ]));
        Route::post('/get-category', [FaqController::class, 'getFaqCategory'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq_category.create',
                    'faq_category.read',
                    'faq_category.write',
                    'faq_category.delete',
                    'faq.create',
                    'faq.read',
                    'faq.write',
                    'faq.delete',
                ]));
        Route::post('/get-question', [FaqController::class, 'getFaqQuestion'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq_category.create',
                    'faq_category.read',
                    'faq_category.write',
                    'faq_category.delete',
                    'faq.create',
                    'faq.read',
                    'faq.write',
                    'faq.delete',
                ]));
        Route::post('/change-category', [FaqController::class, 'changeCategory'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq_category.write',
                ]));
        Route::post('/add-category', [FaqController::class, 'addCategory'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq_category.create',
                ]));
        Route::post('/delete-category', [FaqController::class, 'deleteCategory'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq_category.delete',
                ]));

        Route::post('/change-faq', [FaqController::class, 'changeFaq'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq.write',
                ]));
        Route::post('/add-faq', [FaqController::class, 'addFaq'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq.create',
                ]));
        Route::post('/delete-faq', [FaqController::class, 'deleteFaq'])
            ->middleware('checkRoles:' . implode(',', [
                    'faq.delete',
                ]));
    }
);
