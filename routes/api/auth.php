<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::post('/account-login', [AuthenticatedSessionController::class, 'storeAccount']);
Route::post('/account-register', [RegisteredUserController::class, 'storeAccount']);

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

Route::post('/account-logout', [AuthenticatedSessionController::class, 'destroyAccount'])
    ->middleware(['auth:sanctum']);
