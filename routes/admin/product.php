<?php

use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\GiftCardController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\ReviewController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class)->except([
    'show', 'create', 'store'
]);
Route::resource('products', ProductController::class)->except([
    'show', 'create', 'store'
]);
Route::resource('reviews', ReviewController::class)->only([
    'index', 'update'
]);
Route::resource('gift-cards', GiftCardController::class)->only([
    'index'
]);
Route::get('product/search/{name}',[ProductController::class, 'searchByName'])->name('product.search');
