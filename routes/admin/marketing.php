<?php

use App\Http\Controllers\Admin\Marketing\BannerController;
use App\Http\Controllers\Admin\Marketing\NotificationController;
use App\Http\Controllers\Admin\Marketing\PowerLabelController;
use App\Http\Controllers\Admin\Marketing\PromotionController;
use App\Http\Controllers\Admin\Marketing\SeoController;
use Illuminate\Support\Facades\Route;

Route::resource('banners', BannerController::class)->except([
    'show'
]);
Route::resource('notifications', NotificationController::class)->except([
    'create', 'store', 'show', 'delete'
]);
Route::resource('labels', PowerLabelController::class)->except([
    'show'
]);
Route::resource('promotions', PromotionController::class)->except([
    'show'
]);
Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
Route::post('/seo-store', [SeoController::class, 'store'])->name('seo.store');

Route::get('/get-banners', [BannerController::class, 'getRecords'])->name('banners.get');
Route::get('/get-notifications', [NotificationController::class, 'getRecords'])->name('notifications.get');
Route::get('/get-labels', [PowerLabelController::class, 'getRecords'])->name('labels.get');
Route::get('/get-promotions', [PromotionController::class, 'getRecords'])->name('promotions.get');

