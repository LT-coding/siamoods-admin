<?php

namespace App\Http\Controllers\Haysell;

use App\Http\Controllers\Controller;
use App\Http\Requests\Haysell\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @param LoginService $auth
     */
    public function __construct(private readonly LoginService $auth)
    {
        //
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['ip'] = $request->ip();
        try {
            $auth = $this->auth->login($data);
            return response()->json($auth);
        } catch (ValidationException $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        $this->auth->logout();
        return response()->noContent();
    }
}
