<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DetailController;
use App\Http\Controllers\Api\GeneralCategoryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\VariationController;
use App\Http\Controllers\Api\VariationTypesController;
use App\Http\Controllers\Haysell\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([])->group(function () {
    Route::post('products', [ProductController::class, 'products']);
    Route::post('categories', [CategoryController::class, 'categories']);
    Route::post('general_categories', [GeneralCategoryController::class, 'general_categories']);
    Route::post('variations', [VariationController::class, 'variations']);
    Route::post('variation_types', [VariationTypesController::class, 'variation_types']);
    Route::post('details', [DetailController::class, 'details']);
});

Route::post('idram/result', [PaymentController::class, 'idram']);
Route::post('idram/fail', [PaymentController::class, 'idramFail']);
Route::post('telcell/result', [PaymentController::class, 'telcell']);
Route::post('card/result', [PaymentController::class, 'card']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::group([], function () {
//    foreach (File::files(__DIR__ . '/api') as $file) {
//        require $file;
//    }
//});
