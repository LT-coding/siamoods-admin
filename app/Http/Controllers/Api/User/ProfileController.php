<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AccountUpdateRequest;
use App\Http\Resources\Api\Profile\AccountResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{

    public function edit(Request $request): AccountResource
    {
        return new AccountResource($request->user('sanctum'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(AccountUpdateRequest $request): JsonResponse|Response
    {
        $request->user()->fill($request->validated());

        $request->user()->save();

        $request->user()->updateSubscrption((int) $request->subscribe);

        if ($request->new_password) {
            $request->user()->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
