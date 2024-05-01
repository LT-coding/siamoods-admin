<?php

//use App\Http\Controllers\Api\Site\ContactController;
use App\Http\Controllers\Api\Site\ContentController;
use App\Http\Controllers\Api\Site\SiteController;
use App\Http\Controllers\Api\Site\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap', [SitemapController::class, 'index']);

Route::get('/get-home', [SiteController::class, 'index']);
Route::get('/get-static-metas/{page}', [SiteController::class, 'getStaticMetas']);

Route::get('/get-recently-viewed/{ids}', [SiteController::class, 'getRecentlyViewed']);

Route::get('/blog', [ContentController::class, 'getBlog']);
Route::get('/content/{type}/{slug}', [ContentController::class, 'getContent']);

//Route::post('/send-email', [ContactController::class, 'sendEmail']);
//Route::post('/subscribe', [ContactController::class, 'subscribe']);
////Route::post('/confirm-subscription/{email}', [ContactController::class, 'confirmSubscription']);
//Route::post('/unsubscribe/{email}', [ContactController::class, 'unsubscribe']);
