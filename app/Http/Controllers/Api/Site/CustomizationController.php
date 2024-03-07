<?php

namespace App\Http\Controllers\Api\Site;

use App\Enums\BannerTypes;
use App\Enums\MetaTypes;
use App\Enums\StaticPages;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Site\BannerDataResource;
use App\Http\Resources\Api\Site\CustomizationResource;
use App\Http\Resources\Api\Site\DiscountResource;
use App\Http\Resources\Api\Site\SeoResource;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\FooterMenu;
use App\Models\Meta;
use App\Models\Product;
use App\Models\Social;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomizationController extends Controller
{
    public function getCustomization(Request $request): CustomizationResource
    {
        $data = [
            'footer_menus' => FooterMenu::active()->with('items')->orderBy('order')->get(),
            'social_links' => Social::query()->get(),
            'contacts' => Contact::query()->get(),
        ];

        return new CustomizationResource($data);
    }

    public function getBanners(Request $request): BannerDataResource
    {
        $data = [
            'header_banners' => Banner::query()->active()->where('type', BannerTypes::header->name)->get(),
            'home_banner' => Banner::query()->active()->where('type', BannerTypes::home->name)->orderBy('created_at','desc')->first()
        ];
        return new BannerDataResource($data);
    }

    public function getSale(Request $request): DiscountResource
    {
        $sale = Product::query()->where([['discount_start_date', '<=', Carbon::now()],['discount_end_date', '>=', Carbon::now()]])->orderBy('discount','desc')->first();
        return new DiscountResource($sale);
    }

    public function getStaticMetas(Request $request): SeoResource
    {
        $meta = Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => $request->page])->first()
            ?? Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => StaticPages::home->name])->first();
        return new SeoResource($meta);
    }
}
