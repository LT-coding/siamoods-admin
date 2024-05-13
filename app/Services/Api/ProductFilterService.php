<?php
namespace App\Services\Api;

use App\Http\Resources\Api\Product\CategoryFilterResource;
use App\Http\Resources\Api\Product\ProductShortResource;
use App\Models\Category;
use App\Models\GeneralCategory;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductFilterService
{
    /*
     * Service to filter products
     */
    public function index($request): \Illuminate\Http\Response|JsonResponse
    {
        if ($request->category && !Category::query()->whereHas('meta', function ($query) use ($request) {
                $query->where('url', $request->category);
            })->first()) {
            return response()->noContent(Response::HTTP_NOT_FOUND);
        }
        $products = $this->applyFilters($request);

        $types = GeneralCategory::query()->where([['id', '126']])->first()->categories->where('name', '<>', '-')->where('delete','=','0')->where('name', '<>', '')->where('level', '2')->where('status', 0);
        $stones = GeneralCategory::query()->where('id', '125')->first()->categories->where('name', '<>', '-')->where('delete','=','0')->where('name', '<>', '')->where('status', 0)->sortBy('sort')->filter(
            fn ($item) => $item
                ->products
                ->count()
        );
        $collections = GeneralCategory::query()->where('id', '112')->first()->categories->where('name', '<>', '-')->where('delete','=','0')->where('name', '<>', '')->where('status', 0);
        $minPrice = 100;
        $maxPrice = 50000;

        $response = [
            'types' => CategoryFilterResource::collection($types),
            'stones' => CategoryFilterResource::collection($stones),
            'collections' => CategoryFilterResource::collection($collections),
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'data' => ProductShortResource::collection($products),
//            'links' => [
//                'first' => $products->url(1),
//                'last' => $products->url($products->lastPage()),
//                'prev' => $products->previousPageUrl(),
//                'next' => $products->nextPageUrl(),
//            ],
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

    private function applyFilters(Request $request)
    {
        $type = $request->type;
        $subType = $request->sub_type;
        $stone = $request->stone;
        $collection = $request->filter;
        $discount = $request->discount;
        $balance = $request->balance;
        $sort_by = $request->sort_by;
        $search = $request->search;
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;

        $productsQuery = Product::query()
            ->distinct();

        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('item_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        return $productsQuery->orderBy('created_at', 'desc')->paginate(12);
    }
}
