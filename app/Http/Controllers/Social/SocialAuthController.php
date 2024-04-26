<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialAuthController extends Controller
{
    use UserAuthOrCreate;

    // Facebook login
    public function redirectToFacebook(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback(): JsonResponse
    {
        // Get user
        $user = Socialite::driver('facebook')->user();
        // Auth  User
        $this->register_or_login($user, "facebook");
        // Return profile page after login
        return response()->json([
            'status' => "success",
        ]);
    }


    // Google login
    public function redirectToGoogle(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback(): JsonResponse
    {
        $user = Socialite::driver('google')->stateless()->user();
        $this->register_or_login($user, "google");
        // Return profile page after login
        return response()->json([
            'status' => "success",
        ]);
    }
}
