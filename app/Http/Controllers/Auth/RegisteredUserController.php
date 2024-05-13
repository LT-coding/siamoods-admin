<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function storeAccount(Request $request): JsonResponse
    {
        $user = User::query()->where([['email', $request->email], ['registered', 0]])->first();
        if ($user) {
            $request->validate([
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $user->update([
                'name' => $request->firstName,
                'lastname' => $request->lastName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 0,
                'registered' => 1,
            ]);
        } else {
            $request->validate([
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class . ',email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $user = User::create([
                'name' => $request->firstName,
                'lastname' => $request->lastName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 0,
            ])->assignRole(RoleTypes::account->name);
        }

        event(new Registered($user));

        // Create subscription if checked
        if ($request->subscribe) {
            Subscriber::query()->create([
                'email' => $request->email,
                'status' => 1
            ]);
        }

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }
}
