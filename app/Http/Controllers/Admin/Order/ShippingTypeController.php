<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\ShipAreaEnum;
use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\ShippingTypeRequest;
use App\Models\ShippingType;
use App\Services\Tools\MediaService;
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

        $imagePath = $this->imageService->dispatch($request->file('image'))->upload('shipping'.$data['title'])->getUrl();

        $record = ShippingType::query()->create([
            'name' => $data['name'],
            'image' => $imagePath,
        ]);

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
            'image' => $imagePath,
        ]);

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

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

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
            $row = [$item->id,$item->name,$img, $item->status_text, $created,$btnDetails.$btnDelete];
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
