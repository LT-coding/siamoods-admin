<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShippingType;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.order.orders.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Order::query()->whereNotNull('paid_at')->findOrFail($id);
        $personal = $record->user ?? json_decode($record->personal, true);
        $shipping = $record->address_id && UserAddress::query()->find($record->address_id) ? UserAddress::query()->find($record->address_id) : json_decode($record->shipping, true);
        $statuses = OrderStatuses::getConstants();
        $itemStatuses = OrderItemsStatuses::getConstants();

        return view('admin.order.orders.create-edit', compact('record', 'personal','itemStatuses','shipping', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse|JsonResponse
    {
        $record = Order::query()->findOrFail($request->id);

        $orderShipped = true;

        foreach ($request->item_id as $item_id) {
            $item = CartItem::query()->find($item_id);
            $itemStatus = 'status_'.$item_id;
            $item->update([
                'status' => $request->$itemStatus
            ]);

            if ($request->$itemStatus != OrderItemsStatuses::shipped->name) {
                $orderShipped = false;
            }
        }

        $record->update([
            'status' => $orderShipped ? OrderStatuses::shipped->name : $record->status,
        ]);

        return Redirect::route('admin.orders.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Order::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = Order::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%");
            });
        }

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id','desc')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $created = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d.m.Y');
            $btnDetails = '<a href="'.route('admin.orders.edit',['order'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.orders.destroy', ['order' => $item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = ['<span data-id="'.$item->status.'">'.$item->id.'</span>',Order::STATUS_SHOW[$item->status],$created,$item->user?->display_name,$item->user?->phone,$item->user?->shippingAddress?->zip,$item->paid,$item->payment?->title,$btnDetails.$btnDelete];
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
