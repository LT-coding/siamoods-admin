<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CategoryRequest;
use App\Models\Category;
use App\Models\GeneralCategory;
use App\Services\Tools\MediaService;
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
        $general = GeneralCategory::with('categories')->where('id',126)->first();
        $records = $general->categories->where('level','0');
        $level = Category::query()->max('level');

        return view('admin.product.categories.index', compact('records','level'));
    }

//    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
//    {
//        $record = null;
//
//        return view('admin.product.categories.create-edit', compact('record'));
//    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(CategoryRequest $request): RedirectResponse
//    {
//        $data = $request->validated();
//
//        $data['url'] = str_slug($data['name'],'-');
//        if (Category::query()->where('url',$data['url'])->first()) {
//            return back()->withErrors(['url' => 'The category with the same URL already exists'])->withInput();
//        }
//
//        $imagePath = $this->imageService->dispatch($request->image)->upload('categories')->getUrl();
//        $data['image'] = $imagePath;
//
//        $record = Category::query()->create();
//
//        $record->metas()->create();
//
//        return Redirect::route('admin.categories.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
//    }

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

//        $imagePath = $request->image
//            ? $this->imageService->dispatch($request->image)->upload('categories')->getUrl()
//            : $record->image;
//        $data['image'] = $imagePath;

        $record->update([
            'status' => $data['status']
        ]);

        $record->meta()->update([
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
