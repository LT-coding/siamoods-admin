<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\OrderItemsStatuses;
use App\Enums\OrderStatuses;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\UserAddress;
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
        $records = Order::query()->whereNotNull('paid_at')->get();

        return view('admin.order.orders.index', compact('records'));
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

        return Redirect::route('admin.orders.index')->with('status', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Order::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Removed successfully');
    }
}
