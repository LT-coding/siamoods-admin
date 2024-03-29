<?php

namespace App\Http\Controllers\Haysell;

use App\Http\Controllers\Controller;
use App\Http\Requests\Haysell\HaySellRequest;
use App\Services\Haysell\ProductService;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * @param ProductService $service
     */
    public function __construct(private readonly ProductService $service)
    {
        //
    }

    public function products(HaySellRequest $request): array
    {
        $jsonData = $request->json()->all();

        //       variation
        if (array_key_exists('variation_headers', $jsonData)) {
            $this->service->createVariationTypes($jsonData['variation_headers']);
        }
        if (array_key_exists('variation', $jsonData)) {
            $this->service->createVariations($jsonData['variation']);
        }

        //        category
        if (array_key_exists('category_headers', $jsonData)) {
            $this->service->createGeneralCategory($jsonData['category_headers']);
        }
        if (array_key_exists('filters', $jsonData)) {
            $this->service->createCategory($jsonData['filters']);
        }

        //        delete products
        if (array_key_exists('data', $jsonData)) {
            $this->service->productToDelete($jsonData['data']);
        }

        //        details
        if (array_key_exists('detail_headers', $jsonData)) {
            $this->service->createDetails($jsonData['detail_headers']);
        }

        //        products
        if (array_key_exists('items', $jsonData)) {
            $this->service->createOrUpdateRecord($jsonData['items']);
        }

        //       clients
        if (array_key_exists('clients', $jsonData)) {
            $this->service->createClients($jsonData['clients']);
        }

        //       balance
        if (array_key_exists('balance', $jsonData)) {
            $this->service->updateBalance($jsonData['balance']);
        }

        return [
            'message' => 'Success!'
        ];
    }
}
