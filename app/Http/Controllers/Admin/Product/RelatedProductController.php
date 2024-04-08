<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\RelatedProductRequest;
use App\Models\Product;
use App\Models\RelatedProduct;
use App\Services\Tools\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class RelatedProductController extends Controller
{
    private MediaService $imageService;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $product): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $productItem = Product::query()->find($product);

        return view('admin.product.related-products.create-edit', compact('record','product', 'productItem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RelatedProductRequest $request, int $product): RedirectResponse|JsonResponse
    {
        $data = $request->validated();
        $productItem = Product::query()->find($product);

        $imagePath = $this->imageService->dispatch($request->file('image'))->upload('products/related/'.$productItem->code)->getUrl();

        RelatedProduct::query()->create([
            'product_code' => $productItem->code,
            'title' => $data['title'],
            'image' => $imagePath,
            'additional_price' => $data['additional_price'] ?? 0,
        ]);

        return Redirect::route('admin.products.edit',['product' => $product])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $product, string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = RelatedProduct::query()->findOrFail($id);
        $productTitle = Product::query()->find($product)->title;

        return view('admin.product.related-products.create-edit', compact('record','product', 'productTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RelatedProductRequest $request, int $product, string $id): RedirectResponse|JsonResponse
    {
        $data = $request->validated();
        $record = RelatedProduct::query()->findOrFail($id);
        $productItem = Product::query()->find($product);

        $imagePath = $request->file('image')
            ? $this->imageService->dispatch($request->file('image'))->upload('products/related/'.$productItem->code)->getUrl()
            : $record->image;

        $record->update([
            'title' => $data['title'],
            'image' => $imagePath,
            'additional_price' => $data['additional_price'] ?? 0,
        ]);

        return Redirect::route('admin.products.edit',['product' => $product])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $product, string $id): RedirectResponse
    {
        $record = RelatedProduct::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }
}
