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
Route::get('product/search/{name}',[ProductController::class, 'searchByName'])->name('products.search');
Route::get('/get-products', [ProductController::class, 'getRecords'])->name('products.get');
Route::get('/get-gift-cards', [GiftCardController::class, 'getRecords'])->name('gift-cards.get');
Route::get('/get-reviews', [ReviewController::class, 'getRecords'])->name('reviews.get');
