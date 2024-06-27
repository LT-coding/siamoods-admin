<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\User;
use App\Traits\ReCaptchaCheckTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends Controller
{
    use ReCaptchaCheckTrait;

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
        $request->validate([
            'captchaToken' => ['required'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class . ',email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],[
            'captchaToken.required' => 'Հաստատեք, որ ռոբոտ չեք:',
            'firstName.required' => 'Անուն դաշտը պարտադիր է:',
            'lastName.required' => 'Ազգանուն դաշտը պարտադիր է:',
            'email.required' => 'էլ․ հասցե դաշտը պարտադիր է:',
            'email.email' => 'էլ․ հասցե դաշտը ճիշտ ձևաչափով չէ:',
            'email.unique' => 'Նշված էլ․ հասցեով օգտատեր արդեն գրանցված է:',
            'password.required' => 'Գաղտնաբառ դաշտը պարտադիր է:',
            'password.confirmed' => 'Գաղտնաբառի հաստատումը և գաղտնաբառը պետք է նույնը լինեն:'
        ]);

        $this->checkReCaptcha();

        $user = User::create([
            'name' => $request->firstName,
            'lastname' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,
        ])->assignRole(RoleTypes::account->name);

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $th) {
            $user->delete();

            return response()->json([
                'errors' => ['email' => ['Էլ․ հասցեն գոյություն չունի։']],
                'message' => 'Էլ․ հասցեն գոյություն չունի։'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
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

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }
}
