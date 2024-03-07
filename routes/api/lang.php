<?php

use App\Http\Controllers\Api\LocalizationController;
use Illuminate\Support\Facades\Route;

Route::post('set-language', [LocalizationController::class, 'setLanguage']);
