<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/products',[ProductController::class,'index']);
Route::get('/create',[ProductController::class,'show']);
Route::post('/create',[ProductController::class,'create']);
Route::get('/products/{product}',[ProductController::class,'edit']);

Route::patch('/products/{product}',[ProductController::class,'update']);

Route::delete('/products/{product}/delete',[ProductController::class,'delete']);
