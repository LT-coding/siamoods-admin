<?php

namespace App\Http\Controllers\Api\Product;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ReviewRequest;
use App\Http\Resources\Api\Product\ProductResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private ProductFilterService $service;

    public function __construct(ProductFilterService $service)
    {
        $this->service = $service;
    }

    public function getProducts(Request $request): \Illuminate\Http\Response|JsonResponse
    {
        return $this->service->index($request);
    }

    public function getProduct(string $slug, string $variant): JsonResponse|Response
    {
        $product = Product::query()->where('slug',$slug)->first();
        $variantItem = $product?->variants()?->where('code',$variant)->hasPrices()->available()->first();

        if (!$product || !$variantItem) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'product' => new ProductResource($product),
        ]);
    }

    public function saveReview(ReviewRequest $request): \Illuminate\Http\Response
    {
        $data = $request->validated();
        $data['status'] = StatusTypes::inactive;

        Review::query()->create($data);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
