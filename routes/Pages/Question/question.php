<?php

use App\Http\Controllers\Question\QuestionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'question',],
    function () {
        Route::post('/get', [QuestionController::class, 'getQuestions'])
            ->middleware('checkRoles:' . implode(',', ['administrator']));
        Route::post('/delete', [QuestionController::class, 'deleteQuestions'])
            ->middleware('checkRoles:' . implode(',', ['administrator']));
        Route::post('/send-answer', [QuestionController::class, 'sendAnswer'])
            ->middleware('checkRoles:' . implode(',', ['administrator']));
    }
);
