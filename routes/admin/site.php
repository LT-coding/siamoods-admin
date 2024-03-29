<?php

use App\Http\Controllers\Admin\Site\ContentController;
use App\Http\Controllers\Admin\Site\CustomizationController;
use App\Http\Controllers\Admin\Site\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('customization',[CustomizationController::class,'index'])->name('customization.index');
Route::get('socials/{i}',[CustomizationController::class,'socials'])->name('customization.socials');
Route::post('socials',[CustomizationController::class,'update'])->name('customization.update');

Route::get('menus', [MenuController::class,'index'])->name('menus.index');
Route::any('menus/update', [MenuController::class,'update'])->name('menus.update');

//Route::post('/footer-menu-store', [CustomizationController::class, 'storeFooterMenu'])->name('footer-menu.store');
//Route::post('/footer-menu-update', [CustomizationController::class, 'updateFooterMenu'])->name('footer-menu.update');
//Route::delete('/footer-menu-destroy/{id}', [CustomizationController::class, 'destroyFooterMenu'])->name('footer-menu.destroy');
//
//Route::post('/contact-store', [CustomizationController::class, 'contactInfo'])->name('contact.store');
//Route::post('/social-store', [CustomizationController::class, 'socialLinks'])->name('social.store');
//Route::delete('/social-destroy/{id}', [CustomizationController::class, 'destroySocial'])->name('social.destroy');

Route::resource('{type}/contents', ContentController::class)->except([
    'show'
]);

