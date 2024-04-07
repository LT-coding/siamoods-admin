<?php

namespace App\Http\Controllers\Social;

use App\Enums\RoleTypes;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait UserAuthOrCreate
{
    protected function register_or_login($social_user, $provider): void
    {
        $user = User::firstOrCreate(
            ['email' => $social_user->getEmail()],
            [
                'name' => str_contains($social_user->getName(),' ') ? explode(' ', $social_user->getName())[0] : $social_user->getName(),
                'lastname' => str_contains($social_user->getName(),' ') ? explode(' ', $social_user->getName())[1] : null,
                'email' => $social_user->getEmail(),
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
    }
}
