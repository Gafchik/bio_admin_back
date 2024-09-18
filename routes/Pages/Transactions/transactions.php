<?php
use App\Http\Controllers\Transactions\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'transactions',
    ],
    function () {
        Route::post('/get-types', [TransactionsController::class, 'getTypes'])
            ->middleware('checkRoles:' . implode(',', [
                    'transactions.create',
                    'transactions.read',
                    'transactions.write',
                    'transactions.delete',
                ]));
        Route::post('/get-statuses', [TransactionsController::class, 'getStatuses'])
            ->middleware('checkRoles:' . implode(',', [
                    'transactions.create',
                    'transactions.read',
                    'transactions.write',
                    'transactions.delete',
                ]));
        Route::post('/get-transaction', [TransactionsController::class, 'getTransaction'])
            ->middleware('checkRoles:' . implode(',', [
                    'transactions.create',
                    'transactions.read',
                    'transactions.write',
                    'transactions.delete',
                ]));
        Route::post('/download', [TransactionsController::class, 'download'])
            ->middleware('checkRoles:' . implode(',', [
                    'transactions.create',
                    'transactions.read',
                    'transactions.write',
                    'transactions.delete',
                ]));
        Route::post('/get-transaction-details', [TransactionsController::class, 'getTransactionDetails'])
            ->middleware('checkRoles:' . implode(',', [
                    'transactions.create',
                    'transactions.read',
                    'transactions.write',
                    'transactions.delete',
                ]));
    }
);
