<?php

use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Order\ShippingMethodController;
use Illuminate\Support\Facades\Route;

Route::resource('shipping-methods', ShippingMethodController::class)->except([
    'show'
]);
Route::resource('orders', OrderController::class)->except([
    'show', 'create', 'store'
]);
Route::get('/get-shipping-methods', [ShippingMethodController::class, 'getRecords'])->name('shipping-methods.get');
Route::get('/get-orders', [OrderController::class, 'getRecords'])->name('orders.get');
