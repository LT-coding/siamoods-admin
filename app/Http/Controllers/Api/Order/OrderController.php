<?php

namespace App\Http\Controllers\Api\Order;

use App\Enums\OrderStatuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CartItemRemoveRequest;
use App\Http\Requests\Api\Order\CartItemRequest;
use App\Http\Requests\Api\Order\OrderCreateRequest;
use App\Http\Requests\Api\Order\OrderSaveRequest;
use App\Http\Requests\Api\Order\OrderPaymentRequest;
use App\Http\Resources\Api\Order\CartItemResource;
use App\Http\Resources\Api\Order\CartItemShortResource;
use App\Http\Resources\Api\Order\OrderResource;
use App\Http\Resources\Api\Profile\AccountResource;
use App\Http\Resources\Api\Profile\UserAddressResource;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function getCart(string $user_id): JsonResponse
    {
        $cartItems = CartItem::query()->unordered()->where('user_id',$user_id);
        $summary = $this->getSummary($cartItems);

        return response()->json([
            'cart_items' => CartItemShortResource::collection($cartItems->get()),
            'subtotal' => Product::formatPrice($summary['subtotal']),
            'delivery' => Product::formatPrice($summary['delivery']),
            'total' => Product::formatPrice($summary['total']),
            'currency' => '$'
        ]);
    }

    public function getCartItem(int $item_id): JsonResponse
    {
        $cartItem = CartItem::query()->find($item_id);

        return response()->json([
            'cart_item' => new CartItemResource($cartItem)
        ]);
    }

    public function saveCartItem(CartItemRequest $request): \Illuminate\Http\Response
    {
        // Find an existing CartItem with matching data
        $existingCartItem = CartItem::query()
                ->unordered()
                ->where('user_id', $request->user_id)
                ->where('variant_code', $request->variant)
                ->where('size_code', $request->size)
                ->where('color', $request->color)
                ->where('options', json_encode($request->options))
                ->where('rush_service', $request->rush_service)
                ->where('shipping_method', $request->shipping_method)
                ->where('related', $request->related)
                ->first();

        if ($existingCartItem) {
            // If the item already exists, update its quantity
            $existingCartItem->quantity += $request->total_quantity ?? 1;
            $existingCartItem->save();
        } else {
            $orderItem = CartItem::query()->where(['user_id'=>$request->user_id,'ordered'=>0])->first();
            // If the item doesn't exist, create a new one
            CartItem::query()->unordered()->updateOrCreate([
                'id' => $request->item_id
            ],[
                'user_id' => $request->user_id,
                'variant_code' => $request->variant,
                'size_code' => $request->size,
                'quantity' => $request->total_quantity ?? 1,
                'color' => $request->color,
                'options' => json_encode($request->options),
                'shipping_method' => $request->shipping_method,
                'rush_service' => $request->rush_service,
                'related' => $request->related,
                'order_id' => $orderItem?->order_id,
                'total' => CartItem::getTotal($request->all())['total']
            ]);
        }

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function removeCartItem(CartItemRemoveRequest $request): \Illuminate\Http\Response
    {
        $cartItem = CartItem::query()->find($request->item_id);
        $order = $cartItem->order;
        $cartItem->delete();

        if ($order) {
            $summary = $this->getSummary($order->items);
            $order->update([
                'subtotal' => Product::formatPrice($summary['subtotal']),
                'delivery' => Product::formatPrice($summary['delivery']),
                'total' => Product::formatPrice($summary['total']),
            ]);
        }

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function toCheckout(OrderCreateRequest $request): JsonResponse
    {
        $cartItems = CartItem::query()->whereIn('id',$request->cart_items);

        $summary = $this->getSummary($cartItems);

        $order = Order::query()->updateOrCreate([
            'id' => $cartItems->get()[0]->order_id
        ],[
            'user_id' => $cartItems->get()[0]->user_id,
            'subtotal' => Product::formatPrice($summary['subtotal']),
            'delivery' => Product::formatPrice($summary['delivery']),
            'total' => Product::formatPrice($summary['total']),
            'currency' => '$'
        ]);

        foreach ($cartItems->get() as $cartItem) {
            $cartItem->update([
                'order_id' => $order->id
            ]);
        }

        return response()->json([
            'order_id' => $order->id
        ]);
    }

    public function saveOrder(OrderSaveRequest $request): \Illuminate\Http\Response
    {
        $order = Order::query()->findOrFail($request->order_id);
        $user = $order->user;
        $shipping = $request->shipping;
        $personal = $request->personal;
        $address_id = $request->address_id;

        if ($user && !$address_id && $shipping) {
            if (!$user->mainAddress()) {
                $shipping['is_main'] = 1;
            }
            $shipping['first_name'] = $personal ? $personal['first_name'] : null;
            $shipping['last_name'] = $personal ? $personal['last_name'] : null;
            $shipping['phone_number'] = $personal ? $personal['phone_number'] : null;
            $address = $user->addresses()->create($shipping);
            $address_id = $address->id;
        }
        $order->update([
            'address_id' => $address_id,
            'personal' => $request->personal && !$address_id ? json_encode($request->personal) : null,
            'shipping' => $request->shipping && !$address_id ? json_encode($request->shipping) : null,
        ]);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function payment(OrderPaymentRequest $request): \Illuminate\Http\Response
    {
        $order = Order::query()->findOrFail($request->order_id);
        if ($request->payment_status == 'succeeded') {
            $order->update([
                'code' => Order::generateUniqueCode(),
                'status' => OrderStatuses::confirmed->name,
                'paid_at' => Carbon::now(),
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id
            ]);
        }

        foreach ($order->items as $item) {
            $itemData = $item->toArray();
            $itemData['total_quantity'] = $item->quantity;
            $itemData['variant'] = $item->variant_code;
            $itemData['size'] = $item->size_code;
            $itemData['options'] = json_decode($item->options,true);

            $item->update([
                'ordered' => 1,
                'status' => OrderStatuses::confirmed->name,
                'item_price' => CartItem::getTotal($itemData)['item_price'],
                'discount_percent' => CartItem::getTotal($itemData)['discount_percent'],
                'shipping_price' => CartItem::getTotal($itemData)['shipping_price'],
                'rush_service_price' => CartItem::getTotal($itemData)['rush_service_price'],
                'related_price' => CartItem::getTotal($itemData)['related_price']
            ]);
        }
        $this->decreaseProduct($order);

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function getOrder(int $order_id): JsonResponse
    {
        $order = Order::query()->findOrFail($order_id);
        $user = $order->user;

        return response()->json([
            'shipping' => [
                'personal' => $user ? new AccountResource($user) : json_decode($order->personal, true),
                'addresses' => $user ? UserAddressResource::collection($user->addresses()->get()) : json_decode($order->shipping, true)
            ],
            'order' => new OrderResource($order)
        ]);
    }

    public function getOrders(int $user_id): JsonResponse
    {
        $user = User::query()->find($user_id);

        return response()->json([
            'order' => OrderResource::collection($user->orders)
        ]);
    }

    private function getSummary($cartItems): array
    {
        $total = $cartItems->sum('total');
        $shipping = $cartItems->with('shipping')->get()->sum(function ($cartItem) {
            return $cartItem->shipping_price;
        });
        $rush = $cartItems->with('rushService')->get()->sum(function ($cartItem) {
            return $cartItem->rushService?->service_price;
        });
        $delivery = $shipping + $rush;

        return [
            'subtotal' => $total - $delivery,
            'delivery' => $delivery,
            'total' => $total
        ];
    }

    private function decreaseProduct($order): void
    {
        foreach ($order->items as $item) {
            $size = $item->size;
            $availableQuantity = $size->quantity - $item->quantity;
            $size->update([
                'quantity' => $availableQuantity
            ]);

//            Update quantity in other onordered cart items TODO
//            foreach (CartItem::query()->unordered()->where('size_code', $size->productSizeCode)->get() as $cartItem) {
//                $itemData = $cartItem->toArray();
//                $itemData['total_quantity'] = $item->quantity;
//                $itemData['variant'] = $item->variant_code;
//                $itemData['size'] = $item->size_code;
//                $itemData['options'] = json_decode($item->options,true);
//
//                $item->update([
//                    'quantity' => $item->quantity,
//                    'item_price' => CartItem::getTotal($itemData)['item_price'],
//                    'shipping_price' => CartItem::getTotal($itemData)['shipping_price'],
//                    'total' => CartItem::getTotal($itemData)['total']
//                ]);
//            }
        }
    }
}
