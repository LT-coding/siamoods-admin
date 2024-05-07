<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\AccountUpdateRequest;
use App\Http\Resources\Api\Product\ProductShortResource;
use App\Http\Resources\Api\Profile\AccountAddressResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{

    public function edit(Request $request): AccountAddressResource
    {
        $data = [
            'user' => $request->user('sanctum'),
            'addresses' => $request->user('sanctum')->addresses()->get(),
        ];
        return new AccountAddressResource($data);
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

        $this->saveAddresses($request);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function favorites(Request $request): AnonymousResourceCollection
    {
        $list = $request->user('sanctum')->favorites->pluck('haysell_id')->toArray();
        $products = Product::query()->whereIn('haysell_id', $list)->get();

        return ProductShortResource::collection($products);
    }

    public function addFavorite(Request $request, $haysell_id): \Illuminate\Http\Response
    {
        $request->user('sanctum')->favorites()->updateOrCreate(['haysell_id', $haysell_id]);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function removeFavorite(Request $request, $haysell_id): \Illuminate\Http\Response
    {
        $request->user('sanctum')->favorites()->where('haysell_id', $haysell_id)->first()?->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function clearFavorites(Request $request): \Illuminate\Http\Response
    {
        $request->user('sanctum')->favorites->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    private function saveAddresses($request): void
    {
        $user = $request->user();

        $user->addresses()->updateOrCreate(['type' => 'shipping'],[$request->shipping]);
        if (!$request->shipping['same_for_payment']) {
            $user->addresses()->updateOrCreate(['type' => 'payment'],[$request->payment]);
        } else {
            $user->addresses()->where('type', 'payment')->first()?->delete();
        }
    }
}
