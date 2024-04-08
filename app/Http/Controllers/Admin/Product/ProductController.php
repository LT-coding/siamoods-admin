<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
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

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;

        return view('admin.product.products.create-edit', compact('record'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['code'] = Product::generateUniqueCode();
        $data['slug'] = str_slug($data['name'],'-') . '-' . $data['code'];
        if (Product::query()->where('slug',$data['slug'])->first()) {
            return back()->withErrors(['slug' => 'The product with the same URL already exists'])->withInput();
        }

        $record = $this->saveProduct($data);

        return Redirect::route('admin.products.edit',['product' => $record->id])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Product::query()->findOrFail($id);

        return view('admin.product.products.create-edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = Product::query()->findOrFail($id);

        $data['code'] = $record->code;
        $data['slug'] = str_slug($data['name'],'-') . '-' . $record->code;
        if (Product::query()->where('slug',$data['slug'])->where('id','!=',$id)->first()) {
            return back()->withErrors(['slug' => 'The product with the same URL already exists'])->withInput();
        }

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

    private function saveProduct($data): Builder|Model
    {
        $record = Product::query()->updateOrCreate([
            'code' => $data['code'],
        ],[
            'slug' => $data['slug'],
            'category_code' => $data['category_code'],
            'name' => $data['name'],
            'subtitle' => $data['subtitle'],
            'specification' => $data['specification'],
            'description' => $data['description'],
            'show_in_hot_sales' => $data['show_in_hot_sales'] ?? 0,
            'currency' => $data['currency'],
            'discount' => $data['discount'],
            'discount_start_date' => $data['discount_start_date'],
            'discount_end_date' => $data['discount_end_date'],
        ]);

        $record->metas()->updateOrCreate([
            'type' => MetaTypes::product->name,
            'meta_title' => $data['meta_title'] ?? $data['name'],
            'meta_keywords' => $data['meta_keywords'] ?? $data['name'],
            'meta_description' => $data['meta_description'] ?? $data['description']
        ]);

        return $record;
    }
}
