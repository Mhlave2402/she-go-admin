<?php

use Illuminate\Support\Facades\Route;
use $MODULE_NAMESPACE$\GiftCardManagement\$CONTROLLER_NAMESPACE$\GiftCardManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('giftcardmanagement', GiftCardManagementController::class)->names('giftcardmanagement');
});
