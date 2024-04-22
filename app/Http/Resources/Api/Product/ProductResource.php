<?php

namespace App\Http\Resources\Api\Product;

use App\Http\Resources\Api\Order\ShippingMethodResource;
use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => Product::formatPrice($this->display_price),
            'currency' => $this->currency_sign,
            'discount' => $this->discount_percent,
            'discount_price' => $this->discount_price,
            'variants' => ProductVariantShortResource::collection($this->resource->variants()->hasPrices()->available()->get()),
            'rate_count' => $this->rate_count,
            'rating' => $this->rating,
            'specification' => $this->specification,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            'testimonials' => TestimonialResource::collection($this->testimonials),
            'shipping_methods' => ShippingMethodResource::collection(ShippingMethod::query()->get()),
            'rush_services' => $this->category->rush_service_available ? RushServiceResource::collection($this->category->rushServices) : [],
            'related_products' => RelatedProductResource::collection($this->resource->relatedProducts),
            'pdf' => [
                'productCardPdf' => $this->productCardPdf,
                'sizeChartPdf' => $this->sizeChartPdf,
                'userInformationPdf' => $this->userInformationPdf,
                'declarationPdf' => $this->declarationPdf,
                'technicalSpecificationPdf' => $this->technicalSpecificationPdf,
                'certificationPdf' => $this->certificationPdf,
                'additionalInformationPdf' => $this->additionalInformationPdf,
            ],
        ];
    }
}
