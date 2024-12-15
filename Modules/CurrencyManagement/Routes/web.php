<?php

use Illuminate\Support\Facades\Route;
use $MODULE_NAMESPACE$\CurrencyManagement\$CONTROLLER_NAMESPACE$\CurrencyManagementController;

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
    Route::resource('currencymanagement', CurrencyManagementController::class)->names('currencymanagement');
});
