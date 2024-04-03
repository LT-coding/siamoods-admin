<?php

namespace App\Services\OldDataMigration;

use App\Enums\ContentTypes;
use App\Enums\MetaTypes;
use App\Models\Content;
use App\Models\Meta;
use App\Models\Payment;
use App\Models\ProductRecommendation;
use App\OldModels\Category;
use App\OldModels\Customization;
use App\OldModels\Detail;
use App\OldModels\GeneralCategory;
use App\OldModels\GiftCard;
use App\OldModels\Notification;
use App\OldModels\Banner;
use App\OldModels\Blog;
use App\OldModels\Menu;
use App\OldModels\Order;
use App\OldModels\OrderProduct;
use App\OldModels\Page;
use App\OldModels\Payments;
use App\OldModels\PowerLabel;
use App\OldModels\Product;
use App\OldModels\ProductBalance;
use App\OldModels\ProductCategory;
use App\OldModels\ProductDetail;
use App\OldModels\ProductGift;
use App\OldModels\ProductImage;
use App\OldModels\ProductPowerLabel;
use App\OldModels\ProductPrice;
use App\OldModels\ProductRecomendation;
use App\OldModels\ProductVariation;
use App\OldModels\ProductVariationPrice;
use App\OldModels\Promotion;
use App\OldModels\RecentlyViewed;
use App\OldModels\Review;
use App\OldModels\ShippingArea;
use App\OldModels\ShippingRate;
use App\OldModels\ShippingType;
use App\OldModels\SocialMedia;
use App\OldModels\Subscriber;
use App\OldModels\User;
use App\OldModels\UserPromotion;
use App\OldModels\AccountAddress;
use App\OldModels\Variation;
use App\OldModels\VariationType;
use App\OldModels\WaitingList;
use App\OldModels\WishingList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateData
{
    /**
     * @return void
     */
    public function migrateData(): void
    {
        $this->migrateUserData();
        $this->migrateSiteData();
        $this->migrateCategoryData();
        $this->migrateProductData();
        $this->migrateOrderData();
    }

    private function migrateUserData(): void
    {
        foreach (User::on('old_db')->get() as $item) {
            \App\Models\User::query()->create($item->toArray());
        }
        foreach (UserPromotion::on('old_db')->get() as $item) {
            \App\Models\UserPromotion::query()->create($item->toArray());
        }
        foreach (AccountAddress::on('old_db')->get() as $item) {
            \App\Models\AccountAddress::query()->create($item->toArray());
        }
        foreach (Subscriber::on('old_db')->get() as $item) {
            \App\Models\Subscriber::query()->create($item->toArray());
        }
        foreach (DB::connection('old_db')->table('roles')->get() as $item) {
            DB::table('roles')->insert([
                'id' => $item->id,
                'name' => $item->name,
                'guard_name' => $item->guard_name
            ]);
        }
        foreach (DB::connection('old_db')->table('model_has_roles')->get() as $item) {
            DB::table('model_has_roles')->insert([
                'role_id' => $item->role_id,
                'model_type' => $item->model_type,
                'model_id' => $item->model_id
            ]);
        }
    }

    private function migrateSiteData(): void
    {
        foreach (Banner::on('old_db')->get() as $item) {
            \App\Models\Banner::query()->create($item->toArray());
        }
        foreach (Blog::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['id','name']);
            $data['title'] = $item->name;
            $data['image'] = str_replace('https://siamoods.com','',$item->image);
            $data['type'] = ContentTypes::blog->name;
            $newBlog = Content::query()->create($data);
            $meta = $item->meta;
            Meta::query()->create([
                'type' => MetaTypes::blog->name,
                'model_id' => $newBlog->id,
                'meta_title' => $meta->meta_title,
                'meta_desc' => $meta->meta_desc,
                'meta_key' => $meta->meta_key,
                'url' => $meta->url
            ]);
        }
        foreach (Page::on('old_db')->whereNotIn('name',['Զեղչեր','Նոր տեսականի'])->get() as $item) {
            $data = array_except($item->toArray(),['id','name','parent_page','position']);
            $data['title'] = $item->name;
            $data['type'] = ContentTypes::page->name;
            $newPage = Content::query()->create($data);
            $meta = $item->meta;
            Meta::query()->create([
                'type' => MetaTypes::page->name,
                'model_id' => $newPage->id,
                'meta_title' => $meta->meta_title,
                'meta_desc' => $meta->meta_desc,
                'meta_key' => $meta->meta_key,
                'url' => $meta->url
            ]);
        }
        foreach (Customization::on('old_db')->get() as $item) {
            \App\Models\Customization::query()->create($item->toArray());
        }
        foreach (Menu::on('old_db')->get() as $item) {
            \App\Models\Menu::query()->create($item->toArray());
        }
        foreach (Notification::on('old_db')->get() as $item) {
            \App\Models\Notification::query()->create($item->toArray());
        }
        foreach (Promotion::on('old_db')->get() as $item) {
            \App\Models\Promotion::query()->create($item->toArray());
        }
        foreach (SocialMedia::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $data['image'] = str_replace('https://siamoods.com','',$item->image);
            \App\Models\SocialMedia::query()->create($data);
        }
    }

    private function migrateCategoryData(): void
    {
        foreach (GeneralCategory::on('old_db')->get() as $item) {
            \App\Models\GeneralCategory::query()->create($item->toArray());
        }
        foreach (Category::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $data['recommended'] = $item->recomended;
            $cat = \App\Models\Category::query()->create($data);
            $meta = $item->meta;
            if ($meta) {
                Meta::query()->create([
                    'type' => MetaTypes::category->name,
                    'model_id' => $cat->id,
                    'meta_title' => $meta->meta_title,
                    'meta_desc' => $meta->meta_desc,
                    'meta_key' => $meta->meta_key,
                    'url' => $meta->url
                ]);
            }
        }
        foreach (Detail::on('old_db')->get() as $item) {
            \App\Models\Detail::query()->create($item->toArray());
        }
    }

    private function migrateProductData(): void
    {
        foreach (GiftCard::on('old_db')->get() as $item) {
            \App\Models\GiftCard::query()->create($item->toArray());
        }
        foreach (VariationType::on('old_db')->get() as $item) {
            \App\Models\VariationType::query()->create($item->toArray());
        }
        foreach (Variation::on('old_db')->get() as $item) {
            \App\Models\Variation::query()->create($item->toArray());
        }
        foreach (PowerLabel::on('old_db')->get() as $item) {
            \App\Models\PowerLabel::query()->create($item->toArray());
        }
        foreach (Product::on('old_db')->get() as $item) {
            $prod = \App\Models\Product::query()->create($item->toArray());
            $meta = $item->meta;
            if ($meta) {
                Meta::query()->create([
                    'type' => MetaTypes::product->name,
                    'model_id' => $prod->id,
                    'meta_title' => $meta->meta_title,
                    'meta_desc' => $meta->meta_desc,
                    'meta_key' => $meta->meta_key,
                    'url' => $meta->url
                ]);
            }
        }
        foreach (ProductBalance::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductBalance::query()->create($data);
            }
        }
        foreach (ProductCategory::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductCategory::query()->create($data);
            }
        }
        foreach (ProductDetail::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductDetail::query()->create($data);
            }
        }
        foreach (ProductGift::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductGift::query()->create($data);
            }
        }
        foreach (ProductImage::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id','image','image_path']);
            $data['haysell_image'] = $item->image;
            $data['image'] = $item->image_path;
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductImage::query()->create($data);
            }
        }
        foreach (ProductPowerLabel::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductPowerLabel::query()->create($data);
            }
        }
        foreach (ProductPrice::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductPrice::query()->create($data);
            }
        }
        foreach (ProductRecomendation::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id','recomendation_id']);
            $data['recommendation_id'] = $item->recomendation_id;

            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                ProductRecommendation::query()->create($data);
            }
        }
        foreach (RecentlyViewed::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\RecentlyViewed::query()->create($data);
            }
        }
        foreach (Review::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\Review::query()->create($data);
            }
        }
        foreach (WaitingList::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\WaitingList::query()->create($data);
            }
        }
        foreach (WishingList::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\WishingList::query()->create($data);
            }
        }
        foreach (ProductVariation::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductVariation::query()->create($data);
            }
        }
        foreach (ProductVariationPrice::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id','prod_variation_id']);
            if ($variation = ProductVariation::query()->find($item->prod_variation_id)) {
                $data['variation_haysell_id'] = $variation->variation_haysell_id;
                \App\Models\ProductVariationPrice::query()->create($data);
            }
        }
    }

    private function migrateOrderData(): void
    {
        foreach (Payments::on('old_db')->get() as $item) {
            Payment::query()->create($item->toArray());
        }
        foreach (ShippingType::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $data['image'] = str_replace('https://siamoods.com','',$item->image);
            \App\Models\ShippingType::query()->create($data);
        }
        foreach (ShippingArea::on('old_db')->get() as $item) {
            \App\Models\ShippingArea::query()->create($item->toArray());
        }
        foreach (ShippingRate::on('old_db')->get() as $item) {
            \App\Models\ShippingRate::query()->create($item->toArray());
        }
        foreach (Order::on('old_db')->where('status','<>',Order::UNDEFINED)->get() as $item) {
            $data = array_except($item->toArray(),['shipping_total','submitted_id','submitted_at']);
            $haysellData = $this->getHaysellOrder($item->id);
            if ($haysellData['status'] == "success") {
                $orderInfo = $haysellData['order']['order_info'];
                $orderItems = $haysellData['order']['order_items'];

                $data['delivery_price'] = $orderInfo['delivery_price'] ?? $item->shipping_total ?? 0;
                $data['total'] = $orderInfo['total'] ?? $item->total ?? 0;
                $data['paid'] = reset($orderInfo['payment']) ?? $item->paid ?? 0;
                $data['id'] = $item->id;
                $order = \App\Models\Order::query()->create($data);
                $total = $data['paid'] > 20000 ? 0 : $data['delivery_price'];
                foreach ($orderItems as $key => $orderItem) {
                    $product = Product::on('old_db')->where('haysell_id',$key)->first();
                    $productVariant = ProductVariation::on('old_db')->where('variation_haysell_id',$key)->first();
                    if ($product || $productVariant) {
                        $itemData = $orderItem;
                        $itemData['order_id'] = $item->id;
                        $itemData['haysell_id'] = $product ? $key : $productVariant->haysell_id;
                        $itemData['variation_haysell_id'] = $productVariant ? $key : null;
                        $itemData['discount_price'] = $orderItem['price']*(1-$orderItem['sale']/100);
                        \App\Models\OrderProduct::query()->create($itemData);
                        $total += $itemData['discount_price'];
                    }
                }
                $order->update([
                    'total' => $total
                ]);
            }
        }
    }

    private function getHaysellOrder($id)
    {
        $ch = curl_init();

        $url = config('services.haysell.actions_url');
        $data = array(
            "type" => "checkOrderStatus",
            "profile_id" => config('services.haysell.profile'),
            "token" => config('services.haysell.token'),
            "data" => array(
                "id" => $id
            )
        );

        $jsonData = json_encode($data);

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)
            )
        ));

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch) . ' - ' . $id;
        }

        curl_close($ch);

        return json_decode($response,true);
    }
}
