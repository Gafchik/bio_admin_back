<?php

use App\Http\Controllers\Roles\RolesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'roles',],
    function () {
        Route::post('/get-roles', [RolesController::class, 'getRoles'])
            ->middleware('checkRoles:' . implode(',', ['superuser']));
        Route::post('/edit-roles', [RolesController::class, 'editRoles'])
            ->middleware('checkRoles:' . implode(',', ['superuser']));
        Route::post('/add-roles', [RolesController::class, 'addRoles'])
            ->middleware('checkRoles:' . implode(',', ['superuser']));
        Route::post('/delete-roles', [RolesController::class, 'deleteRoles'])
            ->middleware('checkRoles:' . implode(',', ['superuser']));
    }
);
