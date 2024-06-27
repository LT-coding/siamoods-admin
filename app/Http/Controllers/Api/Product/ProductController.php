<?php

namespace App\Http\Controllers\Api\Product;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ReviewRequest;
use App\Http\Requests\Api\Product\WaitingRequest;
use App\Http\Resources\Api\Product\ProductResource;
use App\Models\Product;
use App\Models\Review;
use App\Models\WaitingList;
use App\Services\Api\ProductFilterService;
use App\Traits\ReCaptchaCheckTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    use ReCaptchaCheckTrait;
    private ProductFilterService $service;

    public function __construct(ProductFilterService $service)
    {
        $this->service = $service;
    }

    public function getProducts(Request $request): \Illuminate\Http\Response|JsonResponse
    {
        return $this->service->index($request);
    }

    public function getStoreData(): \Illuminate\Http\Response|JsonResponse
    {
        return $this->service->storeData();
    }

    public function getGiftCards(): \Illuminate\Http\Response|JsonResponse
    {
        return $this->service->giftCardData();
    }

    public function getProduct(Request $request): ProductResource
    {
        $slug = $request->slug;

        $product = Product::query()->whereHas('meta', function ($query) use ($slug) {
            $query->where('url', $slug);
        })->firstOrFail();

        return new ProductResource($product);
    }

    public function saveReview(ReviewRequest $request): \Illuminate\Http\Response|JsonResponse
    {
        $data = $request->validated();

        $body = $this->checkReCaptcha($request);

        if (!$body->success) {
            return response()->json([
                'errors' => ['reCAPTCHA' => ['Հաստատեք, որ ռոբոտ չեք։']],
                'message' => 'Հաստատեք, որ ռոբոտ չեք։'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data['status'] = StatusTypes::inactive;

        Review::query()->create($data);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function addWaiting(WaitingRequest $request): \Illuminate\Http\Response
    {
        $data = $request->validated();

        WaitingList::query()->updateOrCreate($data);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
