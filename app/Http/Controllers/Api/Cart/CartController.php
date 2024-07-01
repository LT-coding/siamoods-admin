<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\CartStoreRequest;
use App\Http\Resources\Api\Cart\OrderProductIndexResource;
use App\Models\OrderProduct;
use App\Models\ProductVariation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function index(Request $request): JsonResponse|Response
    {
        $userId = $request->user_unique_id ?? $request->user('sanctum')?->id;

        if ($userId) {
            $orderProducts = OrderProduct::cartProducts()
                ->where('user_id', $userId)
                ->with('product')
                ->get();

            $orderProductsCollection = OrderProductIndexResource::collection($orderProducts);
            $productsArray = $orderProductsCollection->toArray(request());

            $totalPrice = 0;
            foreach ($productsArray as $product) {
                $totalPrice += ((int)($product['product']['discount_price'] ?? $product['product']['price']) * (int)$product['quantity']);
            }

            return response()->json([
                'sum' => $totalPrice,
                'products' => $orderProductsCollection
            ]);
        }
        return response()->noContent(Response::HTTP_NOT_FOUND);
    }

    public function store(CartStoreRequest $request): Response
    {
        $data = $request->validated();
        $data['user_id'] = $data['user_unique_id'] ?? $request->user('sanctum')->id;
        $data['variation_haysell_id'] = ProductVariation::find($data['variation_id'] ?? 0)?->variation_haysell_id;

        $orderProduct = OrderProduct::cartProducts()
            ->where('user_id', $data['user_id'])
            ->where('haysell_id', $data['haysell_id'])
            ->where('variation_haysell_id', $data['variation_haysell_id'])
            ->first();

        if ($orderProduct) {
            if (!$data['is_cart']) {
                $data['quantity'] = $orderProduct->quantity + $data['quantity'];
            }
            $orderProduct->update(['quantity' => $data['quantity']]);
        } else {
            OrderProduct::create($data);
        }

        return response()->noContent(Response::HTTP_OK);
    }

    public function delete(OrderProduct $orderProduct): Response
    {
        $orderProduct->delete();
        return response()->noContent();
    }
}
