<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/products',[ProductController::class,'index']);
Route::get('/create',[ProductController::class,'show']);
Route::post('/create',[ProductController::class,'create']);
Route::get('/products/{product}',[ProductController::class,'edit']);

Route::patch('/products/{product}',[ProductController::class,'update']);

Route::delete('/products/{product}/delete',[ProductController::class,'delete']);


Route::post('/payment/success',[PaymentController::class,'success'])->name('payment.success');

Route::post('/payment/fail', function () {
    return 'Payment Failed Callback';
})->name('payment.fail');

Route::post('/payment/cancel', function () {
    return 'Payment Cancelled Callback';
})->name('payment.cancel');


Route::get('/payment/checkout',[PaymentController::class,'index'])->name('payment.index');
Route::post('/payment/checkout',[PaymentController::class,'checkout'])->name('payment.checkout');


