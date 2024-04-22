<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CartItemRequest;
use App\Http\Requests\Api\Product\TestimonialRequest;
use App\Http\Resources\Api\Product\AdditionTypeResource;
use App\Http\Resources\Api\Product\ProductImageResource;
use App\Http\Resources\Api\Product\ProductResource;
use App\Http\Resources\Api\Product\ProductShortResource;
use App\Http\Resources\Api\Product\ProductVariantResource;
use App\Http\Resources\Api\Product\SizeResource;
use App\Models\AdditionTypes;
use App\Models\CartItem;
use App\Models\CategoryRushService;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RelatedProduct;
use App\Models\ShippingMethod;
use App\Models\Testimonial;
use App\Models\VariantSize;
use App\Services\Api\ProductFilterService;
use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
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

    public function getHomeProducts(): AnonymousResourceCollection
    {
        $products = Product::query()->hasPrices()->available()->inRandomOrder()->limit(10)->get();

        return ProductShortResource::collection($products);
    }

    public function getHotSales(): AnonymousResourceCollection
    {
        $products = Product::query()->hasPrices()->available()->where('show_in_hot_sales', 1)->orderBy('created_at', 'desc')->paginate(15);

        return ProductShortResource::collection($products);
    }

    public function getProduct(string $slug, string $variant): JsonResponse|Response
    {
        $product = Product::query()->hasPrices()->available()->notExternal()->where('slug',$slug)->first();
        $variantItem = $product?->variants()?->where('code',$variant)->hasPrices()->available()->first();

        if (!$product || !$variantItem) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'product' => new ProductResource($product),
            'variantItem' => new ProductVariantResource($variantItem),
        ]);
    }

    public function getProductAdditions(): JsonResponse
    {
        return response()->json([
            'arts' => AdditionTypeResource::collection(AdditionTypes::query()->art()->get()),
            'templates' => AdditionTypeResource::collection(AdditionTypes::query()->template()->get()),
        ]);
    }

    public function saveTestimonial(TestimonialRequest $request): \Illuminate\Http\Response
    {
        $data = $request->validated();

        Testimonial::query()->create($data);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function getBlobImage(Request $request): string|Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $imagePath = $request->path;
        $localPath = str_replace(config('app.url').'/storage','',$imagePath);

        $path = 'public' . $localPath;

        if (Storage::exists($path)) {
            $file = Storage::get($path);
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            return response($file, 200, [
                'Content-Type' => 'application/'.$ext,
                'Content-Disposition' => 'inline;filename='.basename($path),
            ]);
        }
        return response()->noContent(Response::HTTP_NOT_FOUND);
    }

    public function getCustomizableImages(string $variant): AnonymousResourceCollection
    {
        $variant = ProductVariant::query()->where('code',$variant)->firstOrFail();

        return ProductImageResource::collection($variant->images()->customizable()->get());
    }

    public function getTotals(CartItemRequest $request): array
    {
        return CartItem::getTotal($request->all())['display_data'];
    }
}
