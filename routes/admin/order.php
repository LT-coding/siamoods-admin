<?php

use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Order\ShippingTypeController;
use Illuminate\Support\Facades\Route;

Route::resource('shipping-types', ShippingTypeController::class);
Route::resource('orders', OrderController::class)->except([
    'show', 'create', 'store'
]);
Route::get('/get-shipping-types', [ShippingTypeController::class, 'getRecords'])->name('shipping-types.get');
Route::get('/get-orders', [OrderController::class, 'getRecords'])->name('orders.get');

Route::get('shipping/free/{k}', [ShippingTypeController::class,'free'])->name('shipping.free');
Route::get('shipping/range/{k}', [ShippingTypeController::class,'range'])->name('shipping.range');
