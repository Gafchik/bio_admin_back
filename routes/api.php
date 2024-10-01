<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

include 'Pages/Auth/auth.php';
Route::group(['middleware' => ['jwt.auth']],
    function () {
        include 'Pages/FAQ/faq.php';
        include 'Pages/Contacts/contacts.php';
        include 'Pages/BaseOnlyTextPages/base-only-text-pages.php';
        include 'Pages/News/news.php';
        include 'Pages/Gallery/gallery.php';
        include 'Pages/Transactions/transactions.php';
        include 'Pages/Question/question.php';
        include 'Pages/Withdraws/withdraws.php';
        include 'Pages/ServerExplorer/server-explorer.php';
        include 'Pages/Roles/roles.php';
    }
);
