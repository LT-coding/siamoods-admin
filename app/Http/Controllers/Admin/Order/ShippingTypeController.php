<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\ShipAreaEnum;
use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\ShippingTypeRequest;
use App\Models\ShippingType;
use App\Services\Tools\MediaService;
use App\Traits\GetRecordsTrait;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShippingTypeController extends Controller
{
    use GetRecordsTrait;

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
        return view('admin.order.shipping-types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $statuses = StatusTypes::statusList();
        $areas = ShipAreaEnum::areas();

        return view('admin.order.shipping-types.create-edit', compact('record', 'statuses', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingTypeRequest $request): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        $imagePath = $this->imageService->dispatch($request->file('image'))->upload('shipping'.$request->title)->getUrl();

        $record = ShippingType::query()->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'cash' => $data['cash'] ?? 0,
            'status' => $data['status'] ?? 0,
            'image' => $imagePath,
        ]);

        if (array_key_exists('area',$data)) {
            foreach ($data['area'] as $key => $area) {
                $shippingArea = $record->areas()->create([
                    'area' => $key,
                    'time' => $area['time']
                ]);
                if (array_key_exists('rate',$area)) {
                    foreach ($area['rate'] as $i => $item) {
                        $shippingArea->rates()->create([
                            'product_cost' => $area['product_cost'][$i] ?? 0,
                            'rate' => $area['rate'][$i],
                        ]);
                    }
                }
            }
        }

        return Redirect::route('admin.shipping-types.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = ShippingType::query()->findOrFail($id);
        $statuses = StatusTypes::statusList();
        $areas = ShipAreaEnum::areas();

        return view('admin.order.shipping-types.create-edit', compact('record', 'statuses', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingTypeRequest $request, string $id): RedirectResponse|JsonResponse
    {
        $data = $request->validated();
        $record = ShippingType::query()->findOrFail($id);

        $imagePath = $request->file('image')
            ? $this->imageService->dispatch($request->file('image'))->upload('shipping'.$record->title)->getUrl()
            : $record->image;

        $record->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'cash' => $data['cash'] ?? 0,
            'status' => $data['status'] ?? 0,
            'image' => $imagePath,
        ]);

        if (array_key_exists('area',$data)) {
            foreach ($data['area'] as $key => $area){
                $shippingArea = $record->areas()->updateOrCreate(['area'=>$key],['time'=>$area['time'],]);
                if (array_key_exists('rate',$area)) {
                    foreach ($area['rate'] as $i => $item) {
                        $shippingArea->rates()->updateOrCreate(['product_cost' => $area['product_cost'][$i] ?? 0],[ 'rate' => $area['rate'][$i]]);
                    }
                }
            }
        }

        return Redirect::route('admin.shipping-types.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = ShippingType::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = ShippingType::query();

        $columns = $orderColumns = ['id', 'name', 'status', 'created_at'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $img = '<img src="'.$item->image_link.'" alt="'.$item->title.'" style="max-width:100%;max-height:100px;">';
            $created = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d.m.Y');
            $btnDetails = '<a href="'.route('admin.shipping-types.edit',['shipping_type'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.shipping-types.destroy',['shipping_type'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->name, $item->status_text, $created, $img, $btnDetails.$btnDelete];
            $data[] = $row;
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }

    public function free(string $k): array
    {
        $record = null;
        return [
            'type' => 1,
            'view' => view('admin.includes.shipping-price',compact('k','record'))->render(),
        ];
    }

    public function range(string $k): array
    {
        $rate = null;
        return [
            'type' => 0,
            'view' => view('admin.includes.shipping-option',compact('k','rate'))->render(),
        ];
    }
}
