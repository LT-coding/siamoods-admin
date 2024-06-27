<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Traits\ReCaptchaCheckTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends Controller
{
    use ReCaptchaCheckTrait;
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /***************** API methods *************************/
    /**
     * Handle an incoming authentication request.
     */
    public function storeAccount(LoginRequest $request): JsonResponse|Response
    {
        $this->checkReCaptcha($request);

        $request->authenticate();

        $user = Auth::user();

        if ($user->isAccount) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token
            ]);
        }

        return response()->json([
            'errors' => ['email' => ['Մուտքանունը կամ գաղտնաբառը սխալ են։']],
            'message' => 'Մուտքանունը կամ գաղտնաբառը սխալ են։'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroyAccount(Request $request): Response
    {
        $request->user('sanctum')->tokens()->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
