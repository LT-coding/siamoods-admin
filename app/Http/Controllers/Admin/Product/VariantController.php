<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\VariantRequest;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Models\VariantImage;
use App\Models\VariantOption;
use App\Services\Tools\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class VariantController extends Controller
{
    private MediaService $imageService;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create(int $product): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $productItem = Product::query()->find($product);
        $options = Option::query()->notColor()->pluck('title','id')->toArray();

        return view('admin.product.variants.create-edit', compact('record','product', 'productItem', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VariantRequest $request, int $product): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        $productItem = Product::query()->find($product);

        $data['code'] = ProductVariant::generateUniqueCode($productItem);
        $record = ProductVariant::query()->create([
            'code' => $data['code'],
            'product_code' => $productItem->code,
            'name' => $request->name,
        ]);

        $this->saveImages($record,$request);
        $this->saveOptions($record,$request);

        return Redirect::route('admin.products.edit',['product' => $product])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $product, string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = ProductVariant::query()->findOrFail($id);
        $productItem = Product::query()->find($product);
        $existingOptions = $record->variantOptions()->pluck('option_code')->toArray();
        $options = Option::query()->whereNotIn('code',$existingOptions)->notColor()->pluck('title','id')->toArray();

        return view('admin.product.variants.create-edit', compact('record','product', 'productItem', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariantRequest $request, int $product, string $id): RedirectResponse|JsonResponse
    {
        $data = $request->validated();
        $record = ProductVariant::query()->findOrFail($id);

        $record->update([
            'name' => $request->name,
        ]);

        $this->saveImages($record,$request);
        $this->saveOptions($record,$data);

        return Redirect::route('admin.products.edit',['product' => $product])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $product, string $id): RedirectResponse
    {
        $record = ProductVariant::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    private function saveImages($record, $request): void
    {
        if ($request->file('images')) {
            foreach ($request->file('images') as $key => $image) {
                $code = VariantImage::generateUniqueCode($record);
                $imagePath = $this->imageService->dispatch($image)->upload('products/variants/'.$record->code)->getUrl();

                $record->images()->create([
                    'viewCode' => $code,
                    'link' => $imagePath,
                    'allow_customization' => $request->allow_customization[$key] ?? 0
                ]);
            }
        }
    }

    private function saveOptions($record, $data): void
    {
        if (!empty($data['options'])) {
            foreach ($data['options'] as $optId) {
                if ($optId) {
                    $option = Option::query()->find($optId);
                    $names = $data['names_'.$optId] ?? [];
                    $values = $data['values_'.$optId] ?? [];
                    $prices = $data['additional_prices_'.$optId] ?? [];
                    if ($option->code == 'color' && !empty($names)) {
                        $variantOption = VariantOption::query()->updateOrCreate([
                            'variant_code' => $record->code,
                            'option_code' => $option->code
                        ]);
                        foreach ($names as $key => $name) {
                            if ($name) {
                                OptionValue::query()->updateOrCreate([
                                    'variant_option_id' => $variantOption->id,
                                    'name' => $name,
                                    'value' => $values[$key],
                                ],[
                                    'additional_price' => $prices[$key] ?? 0
                                ]);
                            }
                        }
                    } elseif (!empty($values)) {
                        $variantOption = VariantOption::query()->updateOrCreate([
                            'variant_code' => $record->code,
                            'option_code' => $option->code
                        ]);
                        foreach ($values as $key => $value) {
                            if ($value) {
                                OptionValue::query()->updateOrCreate([
                                    'variant_option_id' => $variantOption->id,
                                    'name' => $names[$key] ?? null,
                                    'value' => $value,
                                ],[
                                    'additional_price' => $prices[$key] ?? 0
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
