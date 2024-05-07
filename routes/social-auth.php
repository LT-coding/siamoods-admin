<?php

use App\Http\Controllers\Social\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::post('social-login', [SocialAuthController::class, 'store']);
