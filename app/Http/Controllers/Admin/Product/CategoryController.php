<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CategoryRequest;
use App\Models\Category;
use App\Models\GeneralCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $general = GeneralCategory::with('categories')->where('id',126)->first();
        $records = $general->categories->where('level','0');
        $level = Category::query()->max('level');

        return view('admin.product.categories.index', compact('records','level'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Category::query()->findOrFail($id);

        return view('admin.product.categories.create-edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = Category::query()->findOrFail($id);

        $record->update([
            'status' => $data['status']
        ]);

        $record->meta()->updateOrCreate([
            'type' => MetaTypes::category->name,
            'meta_title' => $data['meta_title'],
            'meta_key' => $data['meta_keywords'],
            'meta_desc' => $data['meta_description']
        ]);

        return Redirect::route('admin.categories.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Category::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }
}
