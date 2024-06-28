<?php

use App\Http\Controllers\Api\Cart\CartController;
use Illuminate\Support\Facades\Route;

Route::controller(CartController::class)->prefix('carts')->group(function() {
    Route::get('/','index');
    Route::post('/', 'store');
    Route::delete('/{orderProduct}', 'delete');
});
