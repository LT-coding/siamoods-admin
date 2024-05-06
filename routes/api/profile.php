<?php

use App\Http\Controllers\Api\Profile\OrderController;
use App\Http\Controllers\Api\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'role:account'])->group(static function () {
    Route::get('/account', [ProfileController::class, 'edit']);
    Route::post('/account', [ProfileController::class, 'update']);

    Route::post('/favorites', [ProfileController::class, 'favorites']);
    Route::post('/add-favorite/{haysell_id}', [ProfileController::class, 'addFavorite']);
    Route::delete('/remove-favorite/{haysell_id}', [ProfileController::class, 'removeFavorite']);
    Route::post('/clear-favorites', [ProfileController::class, 'clearFavorites']);

    Route::get('/orders', [OrderController::class, 'getOrders']);
    Route::get('/order-details/{order_id}', [OrderController::class, 'orderDetails']);
});
