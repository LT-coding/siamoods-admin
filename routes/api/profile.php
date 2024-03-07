<?php

use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\UserAddressController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:Account'])->group(static function () {
    Route::get('/account', [ProfileController::class, 'edit']);
    Route::post('/account', [ProfileController::class, 'update']);

    Route::resource('addresses', UserAddressController::class)->except([
        'create', 'edit'
    ]);

    Route::get('/orders', [OrderController::class, 'getOrders']);
    Route::get('/order-details', [OrderController::class, 'orderDetails']);
    Route::get('/order-invoice', [OrderController::class, 'orderInvoice']);
});
