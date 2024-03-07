<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CategoryRequest;
use App\Models\Category;
use App\Services\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    private MediaService $imageService;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $records = Category::query()->get();

        return view('admin.product.categories.index', compact('records'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;

        return view('admin.product.categories.create-edit', compact('record'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['code'] = str_slug($data['title'],'-');
        if (Category::query()->where('code',$data['code'])->first()) {
            return back()->withErrors(['code' => 'The category with the same URL already exists'])->withInput();
        }

        $imagePath = $this->imageService->dispatch($request->image)->upload('categories')->getUrl();
        $data['image'] = $imagePath;

        $record = Category::query()->create([
            'title' => $data['title'],
            'code' => $data['code'],
            'parent_id' => $data['parent_id'],
            'image' => $data['image'],
            'show_in_menu' => $data['show_in_menu'] ?? 0,
            'show_in_best' => $data['show_in_best'] ?? 0,
            'show_in_new' => $data['show_in_new'] ?? 0,
            'rush_service_available' => $data['rush_service_available'] ?? 0,
            'extra_shipping_price' => $data['extra_shipping_price'] ?? 0
        ]);

        $record->metas()->create([
            'type' => MetaTypes::category->name,
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'meta_description' => $data['meta_description']
        ]);

        $this->saveRushServices($record,$data);

        return Redirect::route('admin.categories.index')->with('status', 'Saved successfully');
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

        $data['code'] = str_slug($data['title'],'-');
        if (Category::query()->where('code',$data['code'])->where('id','!=',$id)->first()) {
            return back()->withErrors(['code' => 'The category with the same URL already exists'])->withInput();
        }

        $imagePath = $request->image
            ? $this->imageService->dispatch($request->image)->upload('categories')->getUrl()
            : $record->image;
        $data['image'] = $imagePath;

        $record->update([
            'title' => $data['title'],
            'code' => $data['code'],
            'parent_id' => $data['parent_id'],
            'image' => $data['image'],
            'show_in_menu' => $data['show_in_menu'] ?? 0,
            'show_in_best' => $data['show_in_best'] ?? 0,
            'show_in_new' => $data['show_in_new'] ?? 0,
            'rush_service_available' => $data['rush_service_available'] ?? 0,
            'extra_shipping_price' => $data['extra_shipping_price'] ?? 0
        ]);

        $record->metas()->update([
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'meta_description' => $data['meta_description']
        ]);

        $this->saveRushServices($record,$data);

        return Redirect::route('admin.categories.index')->with('status', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Category::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Removed successfully');
    }

    private function saveRushServices($record, $data): void
    {
        if (!isset($data['rush_service_available'])) {
            $record->rushServices()->delete();
        } else {
            foreach ($data['service_days'] as $key => $val) {
                if ($val) {
                    $record->rushServices()->updateOrCreate([
                        'service_days' => $val
                    ],[
                        'service_price' => $data['service_prices'][$key] ?? 0
                    ]);
                }
            }
        }
    }
}
