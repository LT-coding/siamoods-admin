<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Models\GeneralCategory;
use App\Models\PowerLabel;
use App\Models\Product;
use App\Traits\GetRecordsTrait;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    use GetRecordsTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.product.products.index');
    }

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

    public function getRecords(Request $request): JsonResponse
    {
        $query = Product::query();

        $columns = $orderColumns = ['id', 'articul', 'item_name'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id','desc')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $img = $item->general_image?->image ? '<img src="'.$item->general_image->image.'" alt="image" style="max-height:100px;">' : '-';
            $btnDetails = '<a href="'.route('admin.products.edit',['product'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.products.destroy',['product'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id,$item->articul,$item->item_name,$item->category?->name,$img,$item->price?->price ?? 0,$item->balance?->balance ?? 0,$btnDetails.$btnDelete];
            $data[] = $row;
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }
}
