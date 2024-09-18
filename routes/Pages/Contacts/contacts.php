<?php

use App\Http\Controllers\Contacts\ContactsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'contacts',],
    function () {
        Route::post('/get-info', [ContactsController::class, 'getContactsInfo'])
            ->middleware('checkRoles:' . implode(',', [
                    'contacts.read',
                    'contacts.create',
                    'contacts.write',
                    'contacts.delete',
                ]));
        Route::post('/edit', [ContactsController::class, 'edit'])
            ->middleware('checkRoles:' . implode(',', [
                    'contacts.write',
                ]));
        Route::post('/add', [ContactsController::class, 'add'])
            ->middleware('checkRoles:' . implode(',', [
                    'contacts.create',
                ]));
        Route::post('/delete', [ContactsController::class, 'delete'])
            ->middleware('checkRoles:' . implode(',', [
                    'contacts.delete',
                ]));
    }
);
