<?php

namespace App\Http\Controllers\Social;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SocialAuthController extends Controller
{
    // Social login
    public function store(Request $request): JsonResponse
    {
        $userData = $request->userData;
        $provider = $request->provider;

        $user = User::query()->firstOrCreate(
            ['email' => $userData['email']],
            [
                'name' => $userData['name'],
                'lastname' => $userData['lastname'],
                'password' => Hash::make(Str::random(8)),
                'status' => 0,
                'provider_id' => $provider,
            ]
        );
        $user->markEmailAsVerified();
        $user->assignRole(RoleTypes::account->name);

        event(new Registered($user));

//        TODO need to send email

        Auth::login($user);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }
}
