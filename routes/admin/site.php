<?php

use App\Http\Controllers\Admin\Site\BannerController;
use App\Http\Controllers\Admin\Site\ContentController;
use App\Http\Controllers\Admin\Site\CustomizationController;
use App\Http\Controllers\Admin\Site\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');

Route::post('/footer-menu-store', [CustomizationController::class, 'storeFooterMenu'])->name('footer-menu.store');
Route::post('/footer-menu-update', [CustomizationController::class, 'updateFooterMenu'])->name('footer-menu.update');
Route::delete('/footer-menu-destroy/{id}', [CustomizationController::class, 'destroyFooterMenu'])->name('footer-menu.destroy');

Route::post('/contact-store', [CustomizationController::class, 'contactInfo'])->name('contact.store');
Route::post('/social-store', [CustomizationController::class, 'socialLinks'])->name('social.store');
Route::delete('/social-destroy/{id}', [CustomizationController::class, 'destroySocial'])->name('social.destroy');

Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
Route::post('/seo-store', [SeoController::class, 'store'])->name('seo.store');

Route::resource('banners', BannerController::class)->except([
    'show'
]);
Route::resource('{type}/contents', ContentController::class)->except([
    'show'
]);
