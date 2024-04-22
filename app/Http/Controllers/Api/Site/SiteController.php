<?php

namespace App\Http\Controllers\Api\Site;

use App\Enums\MetaTypes;
use App\Enums\StaticPages;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Site\BannerDataResource;
use App\Http\Resources\Api\Site\SiteResource;
use App\Http\Resources\Api\Site\DiscountResource;
use App\Http\Resources\Api\Site\SeoResource;
use App\Models\Banner;
use App\Models\FooterMenu;
use App\Models\Menu;
use App\Models\Meta;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index(Request $request): SiteResource
    {
        $discount = Product::query()->where('discount', '>', 0)
            ->limit(10)
            ->get()
            ->filter(function ($product) {
                return $product->computed_discount;
            });

        $discount = $discount->values()->all();
        $new = Product::query()->orderBy('haysell_id', 'desc')->whereDoesntHave('categories',function($query){
            $query->where('category_id','27501');
        })->limit(10)->get();
        $liked = Product::query()->where('liked', 1)->limit(10)->get();

        $data = [
            'banners' => Banner::query()->active()->orderBy('order')->get(),
            'header_menu' => Menu::query()->header_menu()->with('children')->orderBy('order')->get(),
            'footer_menu' => Menu::query()->footer_menu()->with('children')->orderBy('order')->get(),
            'discount' => $discount,
            'new' => $new,
            'liked' => $liked,
        ];

        return new SiteResource($data);
    }

    public function getSale(Request $request): DiscountResource
    {
        $sale = Product::query()
            ->where(function ($query) {
                $query->whereNull('discount_start_date')
                    ->orWhere('discount_start_date', '<=', Carbon::now());
            })
            ->where(function ($query) {
                $query->whereNull('discount_end_date')
                    ->orWhere('discount_end_date', '>=', Carbon::now());
            })
            ->orderByDesc('discount')
            ->first();
        return new DiscountResource($sale);
    }

    public function getStaticMetas(Request $request): SeoResource
    {
        $meta = Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => $request->page])->first()
            ?? Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => StaticPages::home->name])->first();
        return new SeoResource($meta);
    }
}
