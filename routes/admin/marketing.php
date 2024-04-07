<?php

use App\Http\Controllers\Admin\Marketing\BannerController;
use App\Http\Controllers\Admin\Marketing\NotificationController;
use App\Http\Controllers\Admin\Marketing\SeoController;
use Illuminate\Support\Facades\Route;

Route::resource('banners', BannerController::class)->except([
    'show'
]);
Route::resource('notifications', NotificationController::class)->except([
    'create', 'store', 'show', 'delete'
]);

Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
Route::post('/seo-store', [SeoController::class, 'store'])->name('seo.store');

