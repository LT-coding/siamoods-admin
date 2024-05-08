<?php

namespace App\Http\Controllers\Api\Site;

use App\Enums\MetaTypes;
use App\Enums\StaticPages;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Product\ProductShortResource;
use App\Http\Resources\Api\Site\SiteResource;
use App\Http\Resources\Api\Site\SeoResource;
use App\Models\Banner;
use App\Models\Content;
use App\Models\Customization;
use App\Models\Menu;
use App\Models\Meta;
use App\Models\Product;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

        $new = Product::query()->orderBy('haysell_id', 'desc')->whereDoesntHave('categories',function($query){
            $query->where('category_id','27501');
        })->limit(10)->get();

        $data = [
            'customizations' => [
                'logo' => Customization::query()->where('type','logo')->first(),
                'copyright' => Customization::query()->where('type','copyright')->first(),
                'payment_delivery' => Customization::query()->where('type','main_item')->get(),
                'header_menu' => Menu::query()->headerMenu()->active()->orderBy('position')->get(),
                'footer_menu' => Menu::query()->footerMenu()->active()->orderBy('position')->get(),
                'social' => SocialMedia::query()->get(),
            ],
            'banners' => Banner::query()->active()->orderBy('order')->get(),
            'discount' => $discount->values()->all(),
            'new' => $new,
            'liked' => Product::query()->where('liked', 1)->limit(10)->get(),
            'blog' => Content::query()->blog()->active()->limit(5)->get()
        ];

        return new SiteResource($data);
    }

    public function getStaticMetas(Request $request): SeoResource
    {
        $meta = Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => $request->page])->first()
            ?? Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => StaticPages::home->name])->first();
        return new SeoResource($meta);
    }

    public function getRecentlyViewed(Request $request): AnonymousResourceCollection
    {
        return ProductShortResource::collection(Product::query()->whereIn('id',$request->ids)->get());
    }
}
