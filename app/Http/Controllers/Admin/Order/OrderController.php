<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Traits\GetRecordsTrait;
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
    use GetRecordsTrait;

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
        $record = Order::query()->findOrFail($id);

        return view('admin.order.orders.create-edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse|JsonResponse
    {
        $record = Order::query()->findOrFail($request->id);

        $record->update($request->except('_token'));

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

        $columns = $orderColumns = ['id', 'order_status', 'created_at', 'user_name', 'phone', 'zip', 'paid', 'payment'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id','desc')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $created = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d.m.Y');
            $btnDetails = '<a href="'.route('admin.orders.edit',['order'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.orders.destroy', ['order' => $item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = ['<span data-id="'.$item->status->value.'">'.$item->id.'</span>',
                $item->status->name(),
                $created,
                $item->user?->display_name,
                $item->user?->phone,
                $item->user?->shippingAddress?->zip,
                Product::formatPrice($item->paid),
                $item->payment?->title,$btnDetails.$btnDelete];
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
