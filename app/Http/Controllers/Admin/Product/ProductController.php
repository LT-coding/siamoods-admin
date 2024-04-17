<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Models\GeneralCategory;
use App\Models\PowerLabel;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $records = Product::query()->orderBy('id','desc')->get();

        return view('admin.product.products.index', compact('records'));
    }

//    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
//    {
//        $record = null;
//
//        return view('admin.product.products.create-edit', compact('record'));
//    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(ProductRequest $request): RedirectResponse
//    {
//        $data = $request->validated();
//
//        $record = $this->saveProduct($data);
//
//        return Redirect::route('admin.products.edit',['product' => $record->id])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
//    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Product::query()->findOrFail($id);
        $generals = GeneralCategory::query()->where('is_main',0)->get();
        $labels = PowerLabel::query()->active()->get();

        return view('admin.product.products.create-edit', compact('record','generals','labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();

        $this->saveProduct($data);

        return Redirect::route('admin.products.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Product::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    private function saveProduct($data): void
    {
        $record = Product::query()->updateOrCreate([
            'id' => $data['id'],
        ],[
            'liked' => $data['liked'] ?? 0
        ]);

        if (!isset($data['gift']) && $record->gift) {
            $record->gift()->delete();
        } else if (isset($data['gift'])) {
            $record->gift()->updateOrCreate([
                'gift_haysell_id' => $data['gift'],
            ]);
        }

        if (!isset($data['label_id']) && $record->label) {
            $record->label()->delete();
        } else if (isset($data['label_id'])) {
            $record->label()->updateOrCreate([
                'haysell_id' => $record->haysell_id
            ],[
                'label_id' => $data['label_id'],
            ]);
        }

        $record->meta()->updateOrCreate([
            'type' => MetaTypes::product->name,
            'meta_title' => $data['meta_title'] ?? $record->item_name,
            'meta_key' => $data['meta_keywords'] ?? $record->item_name,
            'meta_desc' => $data['meta_description'] ?? $record->item_name
        ]);
    }

    public function searchByName(string $name): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $products = Product::query()->where('item_name','like','%'.$name.'%')->get();
        $items = [];
        foreach ($products as $product) {
            $items[] = [
                'id' => $product->haysell_id,
                'name' => $product->item_name,
                'image' => $product->general_image?->image,
            ];
        }

        return response([
            'view' => view('admin.product.products._gift',compact('items'))->render()
        ]);
    }
}
