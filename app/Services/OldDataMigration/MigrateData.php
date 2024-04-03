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
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\User::query()->create(array_merge($data, $timestamps));
        }
        foreach (UserPromotion::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\UserPromotion::query()->create(array_merge($data, $timestamps));
        }
        foreach (AccountAddress::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\AccountAddress::query()->create(array_merge($data, $timestamps));
        }
        foreach (Subscriber::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\Subscriber::query()->create(array_merge($data, $timestamps));
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
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\Banner::query()->create(array_merge($data, $timestamps));
        }
        foreach (Blog::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['id','name']);
            $data['title'] = $item->name;
            $data['image'] = str_replace('https://siamoods.com','',$item->image);
            $data['type'] = ContentTypes::blog->name;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            $newBlog = Content::query()->create(array_merge($data, $timestamps));
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
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            $newPage = Content::query()->create(array_merge($data, $timestamps));
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
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\Customization::query()->create(array_merge($data, $timestamps));
        }
        foreach (Menu::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\Menu::query()->create(array_merge($data, $timestamps));
        }
        foreach (Notification::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\Notification::query()->create(array_merge($data, $timestamps));
        }
        foreach (Promotion::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\Promotion::query()->create(array_merge($data, $timestamps));
        }
        foreach (SocialMedia::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $data['image'] = str_replace('https://siamoods.com','',$item->image);
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\SocialMedia::query()->create(array_merge($data, $timestamps));
        }
    }

    private function migrateCategoryData(): void
    {
        foreach (GeneralCategory::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\GeneralCategory::query()->create(array_merge($data, $timestamps));
        }
        foreach (Category::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $data['recommended'] = $item->recomended;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            $cat = \App\Models\Category::query()->create(array_merge($data, $timestamps));
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
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\Detail::query()->create(array_merge($data, $timestamps));
        }
    }

    private function migrateProductData(): void
    {
        foreach (GiftCard::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\GiftCard::query()->create(array_merge($data, $timestamps));
        }
        foreach (VariationType::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\VariationType::query()->create(array_merge($data, $timestamps));
        }
        foreach (Variation::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\Variation::query()->create(array_merge($data, $timestamps));
        }
        foreach (PowerLabel::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\PowerLabel::query()->create(array_merge($data, $timestamps));
        }
        foreach (Product::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            $prod = \App\Models\Product::query()->create(array_merge($data, $timestamps));
            $meta = $item->meta;
            if ($meta) {
                Meta::query()->create([
                    'type' => MetaTypes::product->name,
                    'model_id' => $prod->haysell_id,
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
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductBalance::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductCategory::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductCategory::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductDetail::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductDetail::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductGift::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductGift::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductImage::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id','image','image_path']);
            $data['haysell_image'] = $item->image;
            $data['image'] = $item->image_path;
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductImage::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductPowerLabel::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductPowerLabel::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductPrice::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductPrice::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductRecomendation::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id','recomendation_id']);
            $data['recommendation_id'] = $item->recomendation_id;

            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                ProductRecommendation::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (RecentlyViewed::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\RecentlyViewed::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (Review::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\Review::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (WaitingList::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\WaitingList::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (WishingList::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\WishingList::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductVariation::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id']);
            $product = Product::query()->find($item->product_id);
            $data['haysell_id'] = $item->haysell_id == 0 && $product ? $product->haysell_id : $item->haysell_id;
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if (Product::query()->where('haysell_id',$data['haysell_id'])->first()) {
                \App\Models\ProductVariation::query()->create(array_merge($data, $timestamps));
            }
        }
        foreach (ProductVariationPrice::on('old_db')->get() as $item) {
            $data = array_except($item->toArray(),['product_id','prod_variation_id']);
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if ($variation = ProductVariation::query()->find($item->prod_variation_id)) {
                $data['variation_haysell_id'] = $variation->variation_haysell_id;
                \App\Models\ProductVariationPrice::query()->create(array_merge($data, $timestamps));
            }
        }
    }

    private function migrateOrderData(): void
    {
        foreach (Payments::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            Payment::query()->create(array_merge($data, $timestamps));
        }
        foreach (ShippingType::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $data['image'] = str_replace('https://siamoods.com','',$item->image);
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\ShippingType::query()->create(array_merge($data, $timestamps));
        }
        foreach (ShippingArea::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\ShippingArea::query()->create(array_merge($data, $timestamps));
        }
        foreach (ShippingRate::on('old_db')->get() as $item) {
            $data = $item->toArray();
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            \App\Models\ShippingRate::query()->create(array_merge($data, $timestamps));
        }
        foreach (Order::on('old_db')->where('status','<>',Order::UNDEFINED)->get() as $item) {
            $data = array_except($item->toArray(),['shipping_total','submitted_id','submitted_at']);
            $haysellData = $this->getHaysellOrder($item->id);
            $timestamps = [
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
            if ($haysellData['status'] == "success") {
                $orderInfo = $haysellData['order']['order_info'];
                $orderItems = $haysellData['order']['order_items'];

                $data['delivery_price'] = $orderInfo['delivery_price'] ?? $item->shipping_total ?? 0;
                $data['total'] = $orderInfo['total'] ?? $item->total ?? 0;
                $data['paid'] = reset($orderInfo['payment']) ?? $item->paid ?? 0;
                $data['id'] = $item->id;
                $order = \App\Models\Order::query()->create(array_merge($data, $timestamps));
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
                        \App\Models\OrderProduct::query()->create(array_merge($itemData, $timestamps));
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
