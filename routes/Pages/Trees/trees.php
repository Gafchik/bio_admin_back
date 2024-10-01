<?php

use App\Http\Controllers\Trees\TreesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'trees',],
    function () {
        Route::post('/get-planting-dates', [TreesController::class, 'getPlantingDates'])
            ->middleware('checkRoles:' . implode(',', [
                'trees.read',
                'trees.write',
            ]));
        Route::post('/get-trees', [TreesController::class, 'getTress'])
            ->middleware('checkRoles:' . implode(',', [
                    'trees.read',
                    'trees.write',
                ]));
        Route::post('/edit-trees', [TreesController::class, 'editTrees'])
            ->middleware('checkRoles:' . implode(',', ['trees.write']));
    }
);
