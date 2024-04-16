<?php

use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class)->except([
    'show', 'create', 'store'
]);
Route::resource('products', ProductController::class)->except([
    'show', 'create', 'store'
]);
Route::resource('testimonials', TestimonialController::class)->only([
    'index', 'update'
]);
