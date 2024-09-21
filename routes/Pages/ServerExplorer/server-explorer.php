<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'server-explorer',],
    function () {
        Route::post('/check', function (){

        })
            ->middleware('checkRoles:' . implode(',', ['superuser']));
    }
);
