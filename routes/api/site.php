<?php

use App\Http\Controllers\Api\Site\ContactController;
use App\Http\Controllers\Api\Site\ContentController;
use App\Http\Controllers\Api\Site\CustomizationController;
use Illuminate\Support\Facades\Route;

Route::get('/get-customization', [CustomizationController::class, 'getCustomization']);
Route::get('/get-banners', [CustomizationController::class, 'getBanners']);
Route::get('/get-sale', [CustomizationController::class, 'getSale']);
Route::get('/get-static-metas/{page}', [CustomizationController::class, 'getStaticMetas']);

Route::get('/blog', [ContentController::class, 'getBlog']);
Route::get('/content/{type}/{slug}', [ContentController::class, 'getContent']);

Route::post('/send-email', [ContactController::class, 'sendEmail']);
Route::post('/subscribe', [ContactController::class, 'subscribe']);
//Route::post('/confirm-subscription/{email}', [ContactController::class, 'confirmSubscription']);
Route::post('/unsubscribe/{email}', [ContactController::class, 'unsubscribe']);
