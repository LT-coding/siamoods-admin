<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    public function setLanguage(Request $request): JsonResponse
    {
        $locale = $request->lang;
        App::setLocale($locale);

        return response()->json([
            'locale' => App::currentLocale()
        ], 200)->withCookie(cookie()->forever('locale',$locale));
    }
}
