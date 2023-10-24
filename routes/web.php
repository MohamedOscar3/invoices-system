<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!

*/
Route::get("/",[\App\Http\Controllers\PaymentController::class,'index'])->name("invoices.index");
Route::post("invoice-signed-link/{id}",[\App\Http\Controllers\PaymentController::class,'generateSignedRoute'])->name("generate-signed-route");
Route::get("invoice/{invoice}",[\App\Http\Controllers\PaymentController::class,"processing"])->name("invoice.pay");
Route::post("payment/return/{invoice}",[\App\Http\Controllers\PaymentController::class,"redirectPayment"])->name("redirect-payment");
Route::post("payment/callback/{invoice}",[\App\Http\Controllers\PaymentController::class,"callbackPayment"])->name("callback-payment");
