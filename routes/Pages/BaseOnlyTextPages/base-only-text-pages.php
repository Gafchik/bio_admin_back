<?php

use App\Http\Controllers\BaseOnlyTextPages\BaseOnlyTextPagesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'base-only-text-pages'],
    function () {
        Route::post('/get', [BaseOnlyTextPagesController::class, 'get'])
            ->middleware('checkRoles:' . implode(',', [
                'page.create',
                'page.read',
                'page.write',
                'page.delete',
            ]));
        Route::post('/edit', [BaseOnlyTextPagesController::class, 'edit'])
            ->middleware('checkRoles:' . implode(',', [
                    'page.create',
                    'page.write',
                    'page.delete',
                ]));
    }
);

