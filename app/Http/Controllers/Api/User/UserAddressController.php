<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\Countries;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserAddressRequest;
use App\Http\Resources\Api\Profile\UserAddressItemResource;
use App\Http\Resources\Api\Profile\UserAddressResource;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): UserAddressResource
    {
        $data = [
            'addresses' => $request->user('sanctum')->addresses()->get(),
            'countries' => Countries::getValues(),
        ];
        return new UserAddressResource($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddressRequest $request): UserAddressItemResource
    {
        $user = Auth::user();
        $data = $request->validated();
        $data['user_id'] = $user->id;

        if ($data['is_main'] == 1) {
            $user->addresses()->update(['is_main' => 0]);
        } elseif (!$user->mainAddress()) {
            $data['is_main'] = 1;
        }

        $address = UserAddress::query()->create($data);

        return new UserAddressItemResource($address);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): UserAddressItemResource
    {
        $address = UserAddress::query()->findOrFail($id);

        return new UserAddressItemResource($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserAddressRequest $request, string $id): Response
    {
        $address = UserAddress::query()->findOrFail($id);
        $data = $request->validated();
        $user = Auth::user();

        if ($data['is_main'] == 1) {
            $user->addresses()->update(['is_main' => 0]);
        } elseif (!$user->mainAddress()) {
            $data['is_main'] = 1;
        }

        $address->update($data);

        return response()->noContent(201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        $address = UserAddress::query()->findOrFail($id);

        $address->delete();

        return response()->noContent(201);
    }
}
