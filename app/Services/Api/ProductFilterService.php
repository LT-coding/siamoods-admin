<?php
namespace App\Services\Api;

use App\Enums\MetaTypes;
use App\Enums\SortType;
use App\Enums\StaticPages;
use App\Http\Resources\Api\Product\CategoryResource;
use App\Http\Resources\Api\Product\CategoryTypeResource;
use App\Http\Resources\Api\Product\ProductShortResource;
use App\Http\Resources\Api\Site\SeoResource;
use App\Models\Category;
use App\Models\Meta;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductFilterService
{
    /*
     * Service to filter products
     */
    public function index($request): Response|JsonResponse
    {
        $productFilter = $this->applyFilters($request);
        $products = $productFilter['products'];
        $minPrice = $productFilter['min_price'];
        $maxPrice = $productFilter['max_price'];

        $response = [
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'data' => ProductShortResource::collection($products),
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

    public function storeData(): Response|JsonResponse
    {
        $types = Category::query()->whereNotIn('name', ['-',''])->where(['general_category_id' => 126, 'delete' => '0', 'level' => '2', 'status' => 1])->get();
        $stones = Category::query()->whereNotIn('name', ['-',''])->where(['general_category_id' => 125, 'delete' => '0', 'status' => 1])->orderBy('sort')->get()
            ->filter(fn ($item) => $item->products()->count());
        $collections = Category::query()->whereNotIn('name', ['-',''])->where(['general_category_id' => 112, 'delete' => '0', 'status' => 1])->get();

        $response = [
            'types' => CategoryTypeResource::collection($types),
            'stones' => CategoryResource::collection($stones),
            'collections' => CategoryResource::collection($collections),
            'seo_meta' => new SeoResource(Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => StaticPages::shop->name])->first())
        ];

        return response()->json($response);
    }

    public function giftCardData(): Response|JsonResponse
    {
        $products = Product::query()
            ->whereHas('categories', function ($query) {
                $query->where('category_id', '27501');
            })->paginate(12);

        $response = [
            'data' => ProductShortResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'from' => $products->firstItem(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'to' => $products->lastItem(),
                'total' => $products->total(),
            ],
            'seo_meta' => new SeoResource(Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => StaticPages::gift_card->name])->first())
        ];

        return response()->json($response);
    }

    private function applyFilters(Request $request): array
    {
        $type = $request->type;
        $subType = $request->sub_type;
        $stone = $request->stone;
        $collection = $request->filter;
        $discount = $request->discount;
        $balance = $request->balance;
        $sort = $request->sort_by ?? 0;
        $search = $request->search;
        $min = $request->min_price;
        $max = $request->max_price;

        $order = isset(SortType::sorts()[$sort]) ? SortType::sorts()[$sort]->name : SortType::sorts()[0]->name;
        $order = explode('0', $order);

        if ($type && is_array($type)) {
            $sub = Category::query()->whereIn('id', $type)->with('childCategories')->get();

            foreach ($sub as $child) {
                foreach ($child->childCategories as $chi) {
                    $type[] = $chi->id;
                }
            }
        }
        if ($subType && is_array($subType)) {
            $type = $subType;
        }
        $productQuery = Product::query()
            ->distinct()
            ->select('products.*')
            ->where('item_name', 'NOT LIKE', 'test product')
            ->whereDoesntHave('categories', function ($query) {
                $query->where('category_id', '27501'); // not gift card
            })
            ->when($type, function ($query, $type) {
                return $query->whereHas('categories', function ($query) use ($type) {
                    if (is_array($type)) {
                        $query->whereIn('category_id', $type);
                    }
                });
            })
            ->when($stone, function ($query, $stone) {
                return $query->whereHas('categories', function ($query) use ($stone) {
                    $query->whereIn('category_id', $stone);
                });
            })
            ->when($collection, function ($query, $collection) {
                return $query->whereHas('categories', function ($query) use ($collection) {
                    $query->whereIn('category_id', $collection);
                });
            })
            ->when($discount, function ($query) {
                return $query->where('discount', '>', 0)->where('discount_end_date','>',Carbon::now());
            })
            ->when($balance, function ($query) {
                return $query->whereDoesntHave('balance', function ($query) {
                    $query->where('balance', '=', 0);
                });
            });

        $productPrice = $productQuery;
        $minPrice = $productPrice->get()->load('prices')->min(function ($product) {
            return $product->prices->min('price');
        });
        $maxPrice = $productPrice->get()->load('prices')->max(function ($product) {
            return $product->prices->max('price');
        });

        $products = $productQuery->whereHas('prices', function ($query) use ($min, $max) {
                if (!is_null($min) && !is_null($max)) {
                    $query->where('price', '>=', $min)->where('price', '<=', $max);
                }
            });

        if ($search) {
            $products->where(function($query) use ($search){
                $query->where('item_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('description', 'LIKE', '%'.$search.'%');
            });
        }

        if ($sort == '3' || $sort == '4') {
            $products->orderBy(
                DB::raw('(SELECT price FROM product_prices WHERE products.haysell_id = product_prices.haysell_id and type="static")'),
                $order[1]
            );
        } elseif ($sort == '5') {
            $products->orderByRaw('CASE WHEN discount_end_date > NOW() THEN 0 ELSE 1 END, discount DESC');
        } elseif ($sort == '6') {
            $products->orderByRaw('CASE WHEN discount_end_date > NOW() AND discount != 0 THEN 0 ELSE 1 END, discount ASC');
        } elseif ($sort == '7') {
            $products->orderByRaw("liked = 1 desc");
        } else {
            $products->orderBy($order[0], $order[1]);
        }

        return [
            'products' => $products->paginate(12),
            'min_price' => $minPrice,
            'max_price' => $maxPrice
        ];
    }
}
