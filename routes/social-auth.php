<?php

use App\Http\Controllers\Social\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::controller(SocialAuthController::class)->group(function () {
    // Google login
    Route::any('login/google', 'redirectToGoogle')->name('login.google');
    Route::get('login/google/callback', 'handleGoogleCallback');

    // Facebook login
    Route::any('login/facebook', 'redirectToFacebook')->name('login.facebook');
    Route::get('login/facebook/callback', 'handleFacebookCallback');
});
