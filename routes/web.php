<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Homepage')->name('home');
Route::inertia('/products', 'Products')->name('products');
Route::inertia('/products/new', 'Products/New')->name('products.new');
Route::inertia('/products/glasses', 'Products/Glasses')->name('products.glasses');
Route::inertia('/products/gloves', 'Products/Gloves')->name('products.gloves');
Route::inertia('/products/respiratory', 'Products/Respiratory')->name('products.respiratory');
