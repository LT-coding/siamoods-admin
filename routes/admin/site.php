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

Route::resource('{type}/contents', ContentController::class)->except([
    'show'
]);

Route::get('/get-contents/{type}', [ContentController::class, 'getRecords'])->name('contents.get');
