<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/products', [ProductController::class, 'getAll']);
Route::get('/products/{id}', [ProductController::class, 'get']);

Route::get('/categories/{id}/products', [CategoryController::class, 'getProducts']);

Route::get('/status/{id}/products', [StatusController::class, 'getProducts']);

Route::get('/productType/{id}/products', [ProductTypeController::class, 'getProducts']);