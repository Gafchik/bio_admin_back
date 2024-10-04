<?php
use App\Http\Controllers\TreeStore\TreeStoreController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'treestore',
    ],
    function () {
        Route::post('/get-treestore', [TreeStoreController::class, 'getTreeStore'])
            ->middleware('checkRoles:' . implode(',', [
                    'superuser',
                    'administrator'
                ]));
    }
);
