<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CartItemRequest;
use App\Http\Requests\Api\Product\TestimonialRequest;
use App\Http\Resources\Api\Product\AdditionTypeResource;
use App\Http\Resources\Api\Product\CategoryShortResource;
use App\Http\Resources\Api\Product\ProductResource;
use App\Http\Resources\Api\Product\ProductShortResource;
use App\Http\Resources\Api\Product\ProductVariantResource;
use App\Http\Resources\Api\Product\SizeResource;
use App\Models\AdditionTypes;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\CategoryRushService;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RelatedProduct;
use App\Models\ShippingMethod;
use App\Models\Testimonial;
use App\Models\VariantSize;
use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function getProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        $products = $this->filter($request)['products'];
        $categories = CategoryShortResource::collection(Category::query()->whereNull('parent_id')->get());
        $filters = $this->filter($request)['filters'];

        $response = [
            'data' => ProductShortResource::collection($products),
            'categories' => $categories,
            'filters' => $filters,
            'links' => [
                'first' => $products->url(1),
                'last' => $products->url($products->lastPage()),
                'prev' => $products->previousPageUrl(),
                'next' => $products->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $products->currentPage(),
                'from' => $products->firstItem(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'to' => $products->lastItem(),
                'total' => $products->total(),
            ],
        ];

        return response()->json($response);
    }

    public function getHomeProducts(): AnonymousResourceCollection
    {
        $products = Product::query()->withPrices()->inRandomOrder()->limit(10)->get();

        return ProductShortResource::collection($products);
    }

    public function getProduct(string $slug, string $variant=null, string $size=null): \Illuminate\Http\JsonResponse|Response
    {
        $product = Product::query()->withPrices()->where('slug',$slug)->first();

        if (!$product) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }

        $variantItem = $variant && $product?->variants()->where('code',$variant)->first() ? $product?->variants()->where('code',$variant)->first() : $product?->variants->first();
        $sizeItem = $size && $variantItem && $variantItem->sizes()->where('productSizeCode',$size)->first() ? $variantItem->sizes()->where('productSizeCode',$size)->first() : $product?->variants->first()?->sizes->first();

        return response()->json([
            'product' => new ProductResource($product),
            'variantItem' => new ProductVariantResource($variantItem),
            'sizeItem' => $sizeItem ? new SizeResource($sizeItem) : null,
        ]);
    }

    public function getProductAdditions(): \Illuminate\Http\JsonResponse
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

    private function filter(Request $request): array
    {
        $category = $request->category;
        $hotSales = $request->hot_sales;
        $search = $request->search;

        $productsQuery = Product::query()
            ->withPrices()
            ->distinct()
            ->select('products.*');

        if ($category) {
            $cat = Category::query()->where('code', $category)->with('childCategories')->first();
            $categories = [$category];
            foreach ($cat->childCategories as $ch) {
                $categories[] = $ch->code;
            }
            $productsQuery->whereIn('category_code',$categories);
        }
        if (isset($hotSales)) {
            $productsQuery->where('show_in_hot_sales',1);
        }

        if ($search) {
            $productsQuery->where(function($query) use ($search){
                $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('subtitle', 'LIKE', '%'.$search.'%')
                    ->orWhere('specification', 'LIKE', '%'.$search.'%')
                    ->orWhere('description', 'LIKE', '%'.$search.'%');
            });
        }

//        filters for products page
        $filters = [];
//        $filters['colors'] = [
//            'title' => 'Color',
//            'values' => VariantResource::collection(Variant::query()->get())
//        ];
        return [
            'products' => $productsQuery->orderBy('created_at','desc')->paginate(15),
            'filters' => $filters
        ];
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

    public function getTotals(CartItemRequest $request): array
    {
        $optionsArray = $optionsItem = [];

        $quantity = $request->total_quantity ?? 1;

        $variantItem = ProductVariant::query()->where('code',$request->variant)->first();
        $sizeItem = VariantSize::query()->where('productSizeCode',$request->size)->first();
        $product = $variantItem->product;
        $sizePrice = $sizeItem->prices()
            ->where('price_from_count','<=',$quantity)
            ->orderBy('price_from_count','desc')
            ->first();
        $rushService = $request->rush_service ? CategoryRushService::query()->find($request->rush_service) : null;
        $related = $request->related ? RelatedProduct::query()->find($request->related) : null;
        $shippingMethod = $request->shipping_method ? ShippingMethod::query()->find($request->shipping_method) : null;
        $shipping = $shippingMethod
            ? $shippingMethod->prices()
                ->where('price_from_count','<=',$quantity)
                ->orderBy('price_from_count','desc')
                ->first()?->price
            : 0;

        if ($request->options) {
            foreach ($request->options as $item) {
                $value = OptionValue::query()->find($item['id']);
                $option = $value->variantOption->option;
                if ($value && $value->additional_price > 0) {
                    $optionsItem['text']= $option->title .' - ' .$value->value;
                    $optionsItem['value']= Product::formatPrice($value->additional_price);
                    $optionsArray []= $optionsItem;
                }
            }
        }

        $unitPrice = $sizePrice->price;
        $discountPrice = $product->discount_percent ? round($unitPrice*(1-$product->discount_percent/100)) : $unitPrice;

        $total = CartItem::getTotal($request->all())['total'];

        return [
            'unit_price' => [
                'text' => 'Unit Price',
                'value' => Product::formatPrice($unitPrice)
            ],
            'total_quantity' => [
                'text' => 'Total quantity',
                'value' => $quantity
            ],
            'unit_total' => [
                'text' => 'Total',
                'value' => Product::formatPrice($unitPrice * $quantity)
            ],
            'sale' => $product->discount_percent ? [
                'text' => 'Sale',
                'value' => $product->discount_percent
            ] : null,
            'discount_total' => $product->discount_percent ? [
                'text' => 'Sale Price',
                'value' => Product::formatPrice($discountPrice * $quantity)
            ] : null,
            'options' => $optionsArray,
            'related' => $related ? [
                'text' => $related->title,
                'value' => Product::formatPrice($related->additional_price)
            ] : null,
            'shipping' => $shippingMethod ? [
                'text' => 'Shipping',
                'value' => Product::formatPrice($shipping)
            ] : null,
            'rush_service' => $rushService ? [
                'text' => 'Rush Service ('.Carbon::now()->addDays($rushService->service_days)->format('M d, Y').')',
                'value' => Product::formatPrice($rushService->service_price)
            ] : null,
            'total' => [
                'text' => 'Total',
                'value' => $total
            ],
        ];
    }
}
