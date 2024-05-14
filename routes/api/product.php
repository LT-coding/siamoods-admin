<?php

use App\Http\Controllers\Api\Product\CategoryController;
use App\Http\Controllers\Api\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/get-categories/{location?}', [CategoryController::class, 'getCategories']);
Route::get('/get-category/{slug}', [CategoryController::class, 'getCategory']);

Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/store-data', [ProductController::class, 'getStoreData']);
Route::get('/gift-cards', [ProductController::class, 'getGiftCards']);
Route::get('/product', [ProductController::class, 'getProduct']);

Route::post('/save-review', [ProductController::class, 'saveReview']);
Route::post('/add-waiting', [ProductController::class, 'addWaiting']);
