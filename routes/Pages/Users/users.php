<?php
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'users',
    ],
    function () {
        Route::post('/get-users', [UsersController::class, 'getUsers'])
            ->middleware('checkRoles:' . implode(',', [
                    'superuser',
                    'administrator'
                ]));
        Route::post('/delete-users', [UsersController::class, 'deleteUsers'])
            ->middleware('checkRoles:' . implode(',', [
                    'superuser',
                    'administrator'
                ]));
        Route::post('/get-users-by-id', [UsersController::class, 'getUserById'])
            ->middleware('checkRoles:' . implode(',', [
                    'superuser',
                    'administrator'
                ]));
        Route::post('/edit-personal-data', [UsersController::class, 'editPersonalData'])
            ->middleware('checkRoles:' . implode(',', [
                    'superuser',
                    'administrator'
                ]));
    }
);
