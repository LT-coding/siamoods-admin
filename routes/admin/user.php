<?php

use App\Http\Controllers\Admin\User\AccountController;
use App\Http\Controllers\Admin\User\SubscriberController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class)->except([
    'show'
]);
Route::resource('accounts', AccountController::class)->except([
    'create', 'store', 'edit', 'update', 'destroy'
]);
Route::resource('subscribers', SubscriberController::class)->except([
    'create', 'store', 'show', 'edit', 'destroy'
]);
