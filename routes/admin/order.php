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
