<?php

namespace App\Http\Controllers\Api\Order;

use App\Enums\Countries;
use App\Enums\OrderStatuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CartItemRemoveRequest;
use App\Http\Requests\Api\Order\CartItemRequest;
use App\Http\Requests\Api\Order\OrderCreateRequest;
use App\Http\Requests\Api\Order\OrderPaymentRequest;
use App\Http\Requests\Api\Order\OrderSaveRequest;
use App\Http\Resources\Api\Order\CartItemResource;
use App\Http\Resources\Api\Order\CartItemShortResource;
use App\Http\Resources\Api\Order\OrderResource;
use App\Http\Resources\Api\Order\StateResource;
use App\Http\Resources\Api\Profile\AccountResource;
use App\Http\Resources\Api\Profile\AccountAddressItemResource;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\Tools\MediaService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    private MediaService $imageService;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function getCart(string $user_id): JsonResponse
    {
        $cartItems = CartItem::query()->unordered()->where('user_id',$user_id);
        $summary = $this->getSummary($cartItems);

        return response()->json([
            'cart_items' => CartItemShortResource::collection($cartItems->get()),
            'subtotal' => Product::formatPrice($summary['subtotal']),
            'delivery' => Product::formatPrice($summary['delivery']),
            'tax' => Product::formatPrice($summary['tax']),
            'total' => Product::formatPrice($summary['total']),
            'currency' => '$'
        ]);
    }

    public function getCartCount(string $user_id): JsonResponse
    {
        return response()->json([
            'count' => CartItem::query()->unordered()->where('user_id',$user_id)->count()
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
        $cartItem = CartItem::query()
                ->unordered()
                ->where('user_id', $request->user_id)
                ->where('variant_code', $request->variant)
                ->where('color', $request->color)
                ->where('options', json_encode($request->options))
                ->where('rush_service', $request->rush_service)
                ->where('shipping_method', $request->shipping_method)
                ->where('related', $request->related)
                ->first();
        $summary = CartItem::getTotal($request->all())['summary'];
        if ($cartItem) {
            // If the item already exists, update its quantity
            $cartItem->rush_service_price += $summary['rush_service_price'];
            $cartItem->related_price += $summary['related_price'];
            $cartItem->total += $summary['total'];
            $cartItem->save();

            foreach ($summary['sizeItems'] as $code => $size) {
                if ($cartItem->sizes()->where('size_code', $code)->exists()) {
                    $size['quantity'] += $cartItem->sizes()->where('size_code', $code)->first()->quantity;
                    $cartItem->sizes()->where('size_code', $code)->first()->update($size);
                } else {
                    $size['size_code'] = $code;
                    $cartItem->sizes()->create($size);
                }
            }
        } else {
            $orderItem = CartItem::query()->where(['user_id'=>$request->user_id,'ordered'=>0])->first();
            // If the item doesn't exist, create a new one
            $cartItem = CartItem::query()->unordered()->updateOrCreate([
                'id' => $request->item_id
            ],[
                'user_id' => $request->user_id,
                'variant_code' => $request->variant,
                'color' => $request->color,
                'options' => json_encode($request->options),
                'shipping_method' => $request->shipping_method,
                'rush_service' => $request->rush_service,
                'related' => $request->related,
                'order_id' => $orderItem?->order_id,
                'discount_percent' => $summary['discount_percent'],
                'shipping_price' => $summary['shipping_price'],
                'rush_service_price' => $summary['rush_service_price'],
                'related_price' => $summary['related_price'],
                'total' => $summary['total']
            ]);
            foreach ($summary['sizeItems'] as $code => $size) {
                $cartItem->sizes()->updateOrCreate([
                    'size_code' => $code,
                ], $size);
            }
        }

        if ($request->customized_images) {
            foreach ($request->customized_images as $ci) {
                $imageData = $ci['image'];
                $imagePath = $this->imageService->dispatchFromBase64($imageData)->upload('product/customized/item-'.$cartItem->id)->getUrl();

                $cartItem->customizedImages()->updateOrCreate([
                    'image_id' => $ci['id'],
                ],[
                    'image' => $imagePath
                ]);
            }
        }

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function removeCartItem(CartItemRemoveRequest $request): \Illuminate\Http\Response
    {
        $cartItem = CartItem::query()->find($request->item_id);
        $order = $cartItem->order;

        $cartItem->sizes()->delete();
        $cartItem->delete();

        if ($order) {
            if ($order->items()->count() > 0) {
                $summary = $this->getSummary($order->items());
                $order->update([
                    'subtotal' => Product::formatPrice($summary['subtotal']),
                    'delivery' => Product::formatPrice($summary['delivery']),
                    'tax' => Product::formatPrice($summary['tax']),
                    'total' => Product::formatPrice($summary['total']),
                ]);
            } else {
                $order->delete();
            }
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
            'tax' => Product::formatPrice($summary['tax']),
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
            'state' => $request->address_id ? UserAddress::query()->find($request->address_id)?->state : $request->shipping['state'] ?? null
        ]);

        $this->getSummary($order->items());

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
            $itemData['variant'] = $item->variant_code;
            $itemData['sizes'] = $item->sizes;
            $itemData['options'] = json_decode($item->options,true);

            $summary = CartItem::getTotal($itemData)['summary'];

            $item->update([
                'ordered' => 1,
                'status' => OrderStatuses::confirmed->name,
                'discount_percent' => $summary['discount_percent'],
                'shipping_price' => $summary['shipping_price'],
                'rush_service_price' => $summary['rush_service_price'],
                'related_price' => $summary['related_price'],
                'total' => $summary['total']
            ]);

            foreach ($summary['sizeItems'] as $code => $size) {
                $item->sizes()->updateOrCreate([
                    'size_code' => $code,
                ], $size);
            }
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
                'addresses' => $user ? AccountAddressItemResource::collection($user->addresses()->get()) : json_decode($order->shipping, true),
            ],
            'countries' => Countries::getValues(),
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

    public function getStates(string $country="Canada"): JsonResponse
    {
        $states = State::query()->where('country',$country)->get();

        return response()->json([
            'states' => StateResource::collection($states)
        ]);
    }

    private function getSummary($cartItems): array
    {
        $total = $cartItems->sum('total');
        $shipping = $cartItems->with('shipping')->get()->sum(function ($cartItem) {
            return $cartItem->shipping_price;
        });
        $rush = $cartItems->with('rushService')->get()->sum(function ($cartItem) {
            return $cartItem->rush_service_price;
        });
        $delivery = $shipping + $rush;
        $tax = 0;
        $totalWithTax = $total;

        $order = $cartItems->count() > 0 ? $cartItems->get()[0]->order : null;
        if ($order && $order->state) {
            $state = State::query()->where('title',$order->state)->first();
            if ($state) {
                $tax = $total * $state->tax/100;
                $totalWithTax = $total + $tax;
                $order->update([
                    'tax' => Product::formatPrice($tax),
                    'total' => Product::formatPrice($totalWithTax),
                ]);
            }
        }

        return [
            'subtotal' => $total - $delivery,
            'delivery' => $delivery,
            'tax' => $tax,
            'total' => $totalWithTax
        ];
    }

    private function decreaseProduct($order): void
    {
        foreach ($order->items as $item) {
            $sizes = $item->sizes;
            foreach ($sizes as $size) {
                $availableQuantity = $size->size->quantity - $size->quantity;
                $size->size->update([
                    'quantity' => $availableQuantity
                ]);
            }

//            Update quantity in other onordered cart items TODO
//            foreach (CartItem::query()->unordered()->where('size_code', $size->code)->get() as $cartItem) {
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
