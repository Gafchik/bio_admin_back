<?php

use App\Http\Controllers\Contacts\ContactsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'contacts',],
    function () {
        Route::post('/get-info', [ContactsController::class, 'getContactsInfo']);
        Route::post('/edit', [ContactsController::class, 'edit']);
        Route::post('/add', [ContactsController::class, 'add']);
        Route::post('/delete', [ContactsController::class, 'delete']);
    }
);
