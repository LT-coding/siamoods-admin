<?php

use App\Http\Controllers\Admin\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('password.update');
