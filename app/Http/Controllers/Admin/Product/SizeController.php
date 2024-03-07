<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\SizeRequest;
use App\Models\ProductVariant;
use App\Models\VariantSize;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class SizeController extends Controller
{
    public function create(int $variant): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $productTitle = ProductVariant::query()->find($variant)->title;
        $product = ProductVariant::query()->find($variant)->product;

        return view('admin.product.sizes.create-edit', compact('record','variant', 'productTitle', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeRequest $request, int $variant): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        $data['code'] = VariantSize::generateUniqueCode(ProductVariant::query()->find($variant));

        $record = VariantSize::query()->create([
            'variant_code' => ProductVariant::query()->find($variant)->code,
            'productSizeCode' => $data['code'],
            'sizeName' => $data['sizeName'],
            'quantity' => $data['quantity'] ?? 0
        ]);

        if ($request->prices) {
            $this->savePrices($record,$data);
        }

        return Redirect::route('admin.sizes.edit',['variant' => $variant,'size' => $record->id])->with('status', 'Saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $variant, string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = VariantSize::query()->findOrFail($id);
        $productTitle = ProductVariant::query()->find($variant)->title;
        $product = ProductVariant::query()->find($variant)->product;

        return view('admin.product.sizes.create-edit', compact('record','variant', 'productTitle', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeRequest $request, int $variant, string $id): RedirectResponse|JsonResponse
    {
        $data = $request->validated();
        $record = VariantSize::query()->findOrFail($id);

        $record->update([
            'sizeName' => $data['sizeName'],
            'quantity' => $data['quantity'] ?? 0
        ]);

        if ($request->prices) {
            $this->savePrices($record,$data);
        }

        return Redirect::route('admin.variants.edit',['product' => $record->variant->product->id,'variant' => $variant])->with('status', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $variant, string $id): RedirectResponse
    {
        $record = VariantSize::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Removed successfully');
    }

    private function savePrices($record, $data): void
    {
        foreach ($data['prices'] as $key => $val) {
            $count = $data['price_from_counts'][$key] ?? 1;
            if ($val) {
                $record->prices()->updateOrCreate([
                    'price_from_count' => $count
                ],[
                    'price' => $data['prices'][$key],
                ]);
            }
        }
    }
}
