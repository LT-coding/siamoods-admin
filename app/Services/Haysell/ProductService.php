<?php

namespace App\Services\Haysell;

use App\Enums\MetaTypes;
use App\Enums\RoleTypes;
use App\Models\Category;
use App\Models\Detail;
use App\Models\GeneralCategory;
use App\Models\Meta;
use App\Models\Product;
use App\Models\ProductBalance;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\ProductGift;
use App\Models\ProductImage;
use App\Models\ProductPowerLabel;
use App\Models\ProductPrice;
use App\Models\ProductRecommendation;
use App\Models\ProductVariation;
use App\Models\ProductVariationPrice;
use App\Models\User;
use App\Models\Variation;
use App\Models\VariationType;
use App\Services\Tools\MediaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Throwable;

class ProductService
{
    private $product, $details, $images, $prices, $categories, $balance, $meta, $attributes, $recommendations, $label;
    private $variation;
    private $gift;
    private MediaService $imageService;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @param $items
     * @return void
     */

    public function createOrUpdateRecord($items): void
    {
        foreach ($items as $key => $item) {
            $this->createOrUpdateProduct($item);
        }
    }

    public function createOrUpdateProduct(array $data): void
    {
        $this->dataManager($data);
        DB::transaction(function () {
            $this->createProduct();
            $this->createProductDetails();
            $this->createProductBalance();
            $this->createProductCategories();
            $this->createProductPrices();
            $this->createProductImages();
            $this->createProductMeta();
            $this->createProductVariation();
            $this->createProductGift();
            $this->createProductRecommendations();
            $this->createProductPowerLabel();
            try {
                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                throw new RuntimeException($e->getMessage());
            }
        });

    }

    public function dataManager($data): void
    {
        if (array_key_exists('power_label', $data)) {
            $this->label = $data['power_label'];
        } else {
            $this->label = null;
        }
        if (array_key_exists('attributes', $data)) {
            $this->attributes = $data['attributes'];
        } else {
            $this->attributes = [];
        }
        if (array_key_exists('recomendations', $data['additional'])) {
            $this->recommendations = $data['additional']['recomendations'];
        } else {
            $this->recommendations = '';
        }

        $this->product = $data['static'];
        if (array_key_exists('balance', $data['additional'])) {
            $this->balance = $data['additional']['balance'];
        } else {
            $this->balance = 0;
        }
        $this->details = array_key_exists('detail',$data['additional'])?$data['additional']['detail']:[];
        $this->images =[];
        if (array_key_exists('images', $data['additional'])) {
            if($data['additional']['images']){
                $this->images = $data['additional']['images'];
            }
            if (array_key_exists('image_path', $this->product)) {
                $this->images = array_merge($this->images,['general'=>$this->product['image_path']]);
                unset($this->product['image_path']);
            }
        }
        if (array_key_exists('prices', $data['additional'])) {
            $this->prices = $data['additional']['prices'];
        } else {
            $this->prices = [];
        }
        if (array_key_exists('price', $data['static'])) {
            $this->prices['static'] = $data['static']['price'];
        } else {
            $this->prices['static'] = [];
        }
        if (array_key_exists('price', $data['additional'])) {
            $this->prices['additional'] = $data['additional']['price'];
        } else {
            $this->prices['additional'] = [];
        }
        if (array_key_exists('filters', $data['additional'])) {
            $this->categories['filters'] = $data['additional']['filters'];
        } else {
            $this->categories['filters'] = [];
        }
        if (array_key_exists('category', $data['additional'])) {
            $this->categories['basic'] = $data['additional']['category'];
        } else {
            $this->categories['basic'] = [];
        }
        if (array_key_exists('detail', $data['additional']) && !array_key_exists('meta', $data['additional'])) {
            $meta = [
                'url'=>$data['additional']['detail']['118'],
                'meta_title'=>$data['static']['item_name'],
                'meta_desc'=>array_key_exists('89',$data['additional']['detail'])?$data['additional']['detail']['89']:'',
                'meta_key'=>Category::query()->where('id',$data['additional']['category'])->first()->name,
            ];

            $this->meta = $meta;
        }elseif(array_key_exists('meta', $data['additional'])){
            $this->meta = $data['additional']['meta'];
        } else {
            $this->meta = [];
        }

        if (array_key_exists('gift', $data)) {
            $this->gift = $data['gift'];
        } else {
            $this->gift = null;
        }
    }

    private function createProduct(): void
    {
        unset($this->product['price']);
        if (array_key_exists('discount_end_date', $this->product) && !$this->product['discount_end_date']) {
            unset($this->product['discount_end_date']);
        }
        if (array_key_exists('articul', $this->product)) {
            if (!Product::query()->where('articul',$this->product['articul'])->first()) {
                $this->product['haysell_id'] = $this->product['id'];
            }
            $this->record = Product::query()->updateOrCreate(['articul' => $this->product['articul']], $this->product);
        } else {
            $this->product['haysell_id'] = 0;
            $this->record = Product::query()->updateOrCreate($this->product);
        }
    }

    private function createProductMeta(): void
    {
        if (!empty($this->meta)) {
            $data = $this->meta;
            $data['haysell_id'] = $this->record->haysell_id ?? 0;
            $this->meta = Meta::query()->updateOrCreate([
                'model_id' => $this->record->id,
                'type' => MetaTypes::product->name
            ], $data);
        }
    }

    private function createProductVariation(): void
    {
        if (!empty($this->attributes)) {
//            Log::info('rec',[$this->record]);
//            Log::info('variations', $this->attributes);
            foreach ($this->attributes as $key => $attributes) {
                $data['variation_id'] = $attributes['variation_id'];
                $data['variation_haysell_id'] = $key;
                $data['balance'] = $attributes['balance'];
                if (array_key_exists('image', $attributes) && !is_null($attributes['image'])) {
                    $data['image'] = $attributes['image'];
                }
                $data['status'] = $attributes['active'];
                $data['haysell_id'] = $this->record->haysell_id;
                $this->variation = ProductVariation::query()->updateOrCreate(['haysell_id' => $this->record->haysell_id, 'variation_id' => $data['variation_id']], $data);
                if (is_array($attributes['price'])) {
                    foreach ($attributes['price'] as $k => $price) {
                        $prices['prod_variation_id'] = $this->variation->id;
                        $prices['type'] = $k;
                        $prices['price'] = $price;
                        ProductVariationPrice::query()->updateOrCreate(['prod_variation_id' => $prices['prod_variation_id'], 'type' => $prices['type']], $prices);
                    }
                }
            }
        }
    }

    private function createProductDetails(): void
    {
        foreach ($this->details as $key => $detail) {
            $data['detail_id'] = $key;
            $data['value'] = $detail;
            $data['haysell_id'] = $this->record->haysell_id;
            $det = Detail::query()->find($data['detail_id']);
            if (!is_null($detail) && $det) {
                ProductDetail::query()->updateOrCreate(['haysell_id' => $data['haysell_id'], 'detail_id' => $data['detail_id']], $data);
            }
        }
    }

    private function createProductCategories(): void
    {
        $data = null;
        ProductCategory::query()->where('haysell_id',$this->record->haysell_id)->delete();
//        Log::info('cat',$this->categories);
        foreach ($this->categories as $key => $category) {
            if (is_array($category)) {
                foreach ($category as $name => $value) {
                    if(str_contains($value, ',')){
                        $value = explode(',', $value);
                        foreach ($value as $val){
                            $data['general_category_id'] = $name;
                            $data['category_id'] = $val;
                            $data['type'] = $key;
                            $data['haysell_id'] = $this->record->haysell_id;
                            if ($data && $data['category_id'] && Category::query()->where('general_category_id',($data['general_category_id']))->first()) {
                                ProductCategory::query()->create($data);
                            }
                        }
                    } else {
                        $data['general_category_id'] = $name;
                        $data['category_id'] = $value;
                        $data['type'] = $key;
                        $data['haysell_id'] = $this->record->haysell_id;
                        if ($data && $data['category_id']) {
                            ProductCategory::query()->create( $data);
                        }
                    }
                }
            } else {
                if (str_contains($category, ',')) {
                    $category = explode(',', $category);
                    foreach ($category as $cat){
                        $data['general_category_id'] = 126;
                        $data['category_id'] = (int)$cat;
                        $data['type'] = $key;
                        $data['haysell_id'] = $this->record->haysell_id;
                        if ($data && $data['category_id']) {
                            ProductCategory::query()->create( $data);
                        }
                    }
                } else {
                    $data['general_category_id'] = 126;
                    $data['category_id'] = $category;
                    $data['type'] = $key;
                    $data['haysell_id'] = $this->record->haysell_id;
                    if ($data && $data['category_id']) {
                        ProductCategory::query()->create( $data);
                    }
                }
            }
        }
    }

    private function createProductPrices(): void
    {
        foreach ($this->prices as $key => $price) {
            if ($price) {
                $data['haysell_id'] = $this->record->haysell_id ?? 0;
                $data['type'] = $key;
                $data['price'] = $price;
                ProductPrice::query()->updateOrCreate(['haysell_id' => $data['haysell_id'], 'type' => $data['type']], $data);
            }
        }
    }

    private function createProductImages(): void
    {
        if ($this->images) {
        ProductImage::query()
            ->where('haysell_id',$this->record->haysell_id)
            ->delete();
            foreach ($this->images as $key => $image) {
                $data['haysell_id'] = $this->record->haysell_id;
                $data['haysell_image'] = $image;
//                Store image in storage
                $imagePath = $this->storeImage($image, $this->record->haysell_id);
                $data['image'] = $imagePath;
                if ($key == 'general') {
                    $data['is_general'] = 1;
                } else {
                    $data['is_general'] = 0;
                }
                ProductImage::query()->updateOrCreate($data);
            }
        }
    }

    private function createProductBalance(): void
    {
//        Log::info('rec',[$this->record]);
//        Log::info('product_balance', [$this->balance]);
        $data['haysell_id'] = $this->record->haysell_id;
        $data['balance'] = $this->balance;
        ProductBalance::query()->updateOrCreate(['haysell_id' => $this->record->haysell_id],$data);
    }

    private function createProductGift(): void
    {
        if ($this->gift) {
            $data['haysell_id'] = $this->record->haysell_id;
            $data['gift_product_id'] = $this->gift;
            ProductGift::query()->updateOrCreate(['haysell_id' => $data['haysell_id']], $data);
        }
    }

    private function createProductRecommendations(): void
    {
        if ($this->recommendations != '') {
            $array = explode(',', $this->recommendations);
//            Log::info('rec',[$this->record]);
            foreach (ProductRecommendation::query()->where('haysell_id', $this->record->haysell_id)->whereNotIn('recomendation_id',$array)->get() as $item) {
                $item->delete();
            }
//            Log::info('recommend', $array);
            foreach ($array as $item) {
                ProductRecommendation::query()->updateOrCreate([
                    'haysell_id' => $this->record->haysell_id,
                    'recommendation_id' => $item
                ],[
                    'haysell_id' => $this->record->haysell_id,
                    'recommendation_id' => $item
                ]);
            }
        }
    }

    private function createProductPowerLabel(): void
    {
        if ($this->label) {
            ProductPowerLabel::query()->updateOrCreate(['haysell_id' => $this->record->haysell_id], [
                'label_id' => $this->label,
            ]);
        }
    }

//    variation
    public function createVariationTypes($variation_types): void
    {
        foreach ($variation_types as $variation_type)
            VariationType::query()->updateOrCreate($variation_type);
    }

    public function createVariations($variations): void
    {
        foreach ($variations as $variation) {
            $data = [
                'id' => $variation['id'],
                'variation_type_id' => $variation['type_id'],
                'title' => $variation['title'],
                'deleted' => $variation['deleted'],
            ];
            Variation::query()->updateOrCreate($data);
        }
    }

//    category
    public function createGeneralCategory($category_headers): void
    {
        foreach ($category_headers as $category_header) {
            if(array_key_exists('title',$category_header)) {
                $data = [
                    'id' => $category_header['id'],
                    'title' => $category_header['title'],
                    'show_in_item' => $category_header['show_in_item'],
                    'show_in_web' => $category_header['show_in_web'],
                    'is_main' => $category_header['is_main'],
                    'is_price' => $category_header['is_price'],
                ];
                GeneralCategory::query()->updateOrCreate($data);
            }
        }
    }

    public function createCategory($categories): void
    {
        foreach ($categories as $category) {

            $data = [
                'id' => $category['id'],
                'parent_id' => $category['parent_id'],
                'general_category_id' => $category['cat_id'],
                'name' => $category['name'],
                'level' => $category['level'],
                'short_url' => $category['short_url'],
                'status' => $category['active'],
                'additional' => $category['additional'],
                'extra_categories' => $category['extra_categories'],
                'sort' => $category['sort'],
                'recommended' => $category['recomended'],
                'is_top' => $category['is_top'],
                'image' => $category['image'],
                'logo' => $category['logo'],
                'delete' => $category['deleted'],
            ];
            $dataCheck = [
                'id' => $category['id'],
                'parent_id' => $category['parent_id'],
                'general_category_id' => $category['cat_id'],
                'name' => $category['name'],
            ];
            Category::query()->updateOrCreate($dataCheck,$data);
        }
    }

    public function productToDelete($delete_items): void
    {
        $pattern = '/,+/';

        $array = preg_split($pattern, $delete_items['deleted_items']);
        foreach ( $array as $item) {
            Product::query()->where('haysell_id',$item)->delete();
        }
    }

//    details
    public function createDetails($details): void
    {
        foreach ($details as $detail) {
            $data = [
                'id' => $detail['id'],
                'name' => $detail['name'],
                'type' => $detail['type'],
                'order' => $detail['order'],
            ];
            Detail::query()->updateOrCreate($data);
        }
    }

    public function createClients($clients): void
    {

        foreach ($clients as $client) {
            if(count($client['email'])) {
                $data = [
                    'haysell_id' => $client['id'],
                    'email' => $client['email'][0],
                    'name' => $client['first_name'],
                    'lastname' => $client['last_name'],
                    'password' => Hash::make('qweasdzxc'),
                    'phone' => count($client['phone'])?$client['phone'][0]:null,
                    'registered' => 0,
                ];
                if (preg_match('/(\d+)%/', $client['schema_name'], $matches)) {
                    $data['discount'] = (int)$matches[1];
                }

                User::query()->updateOrCreate(['email'=>$data['email']],$data)->assignRole(RoleTypes::account->name);
            }
        }
    }

    public function updateBalance($balances): void
    {
        foreach ($balances as $key => $balance) {
            ProductBalance::query()->where('haysell_id','=',$key)->update([
                'balance' => $balance
            ]);
            ProductVariation::query()->where('variation_haysell_id','=',$key)->update([
                'balance' => $balance
            ]);
        }
    }

    private function storeImage($imgUrl, $haysell_id): string
    {
        return $this->imageService->dispatchFromUrl($imgUrl)->upload('products/product_'.$haysell_id)->getUrl();
    }
}
