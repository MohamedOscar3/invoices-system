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


                            /** Auth routes */
/********************** ************************** *******************/


Route::prefix("auth")->group(function () {

   Route::post("login",\App\Http\Controllers\ApiControllers\Auth\LoginController::class);
   Route::post("request-otp",[\App\Http\Controllers\ApiControllers\Auth\ForgetPasswordController::class,"requestOtp"]);
   Route::post("verify-otp",[\App\Http\Controllers\ApiControllers\Auth\ForgetPasswordController::class,"verifyOtp"]);
   Route::post("change-otp-password",[\App\Http\Controllers\ApiControllers\Auth\ForgetPasswordController::class,"changePassword"]);
});

/********************** ********* ************* *******************/


                            /** Auth routes */
/********************** ************************** *******************/

Route::middleware('auth:sanctum')->group(function () {
   Route::get("user",[\App\Http\Controllers\ApiControllers\UserController::class,"check"]);

                            /** Invoices routes */
    /********************** ************************** *******************/

    Route::resource("invoices",\App\Http\Controllers\ApiControllers\InvoiceController::class);

    /********************** ************************** *******************/

                              /** Currencies routes */
    /********************** ************************** *******************/

    Route::resource("currencies",\App\Http\Controllers\ApiControllers\CurrencyController::class)->except(["destroy"]);

    /********************** ************************** *******************/
});

/********************** ********* ************* *******************/
