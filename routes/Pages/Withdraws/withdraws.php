<?php

use App\Http\Controllers\Withdraws\WithdrawsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'withdraws',],
    function () {
        Route::post('/get', [WithdrawsController::class, 'getWithdraws'])
            ->middleware('checkRoles:' . implode(',', ['superuser']));
        Route::post('/edit', [WithdrawsController::class, 'editWithdraws'])
            ->middleware('checkRoles:' . implode(',', ['superuser']));
        Route::post('/info', [WithdrawsController::class, 'infoWithdraws'])
            ->middleware('checkRoles:' . implode(',', ['superuser']));
    }
);
