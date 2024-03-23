<?php

use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\RelatedProductController;
use App\Http\Controllers\Admin\Product\SizeController;
use App\Http\Controllers\Admin\Product\OptionController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\AdditionController;
use App\Http\Controllers\Admin\Product\TestimonialController;
use App\Http\Controllers\Admin\Product\VariantController;
use Illuminate\Support\Facades\Route;

Route::resource('options', OptionController::class)->except([
    'show'
]);
Route::resource('categories', CategoryController::class)->except([
    'show'
]);
Route::resource('products', ProductController::class)->except([
    'show'
]);
Route::resource('{product}/related-products', RelatedProductController::class)->except([
    'index','show'
]);
Route::resource('{product}/variants', VariantController::class)->except([
    'index','show'
]);
Route::resource('{variant}/sizes', SizeController::class)->except([
    'index','show'
]);
Route::resource('testimonials', TestimonialController::class)->only([
    'index'
]);
