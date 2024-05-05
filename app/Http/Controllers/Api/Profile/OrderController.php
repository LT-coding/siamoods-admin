<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Order\UserOrderDetailsResource;
use App\Http\Resources\Api\Order\UserOrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function getOrders(Request $request): AnonymousResourceCollection
    {
        $user = $request->user('sanctum');
        return UserOrderResource::collection($user->orders);
    }

    public function orderDetails(Request $request): UserOrderDetailsResource
    {
        $user = $request->user('sanctum');
        $order = $user->orders()->where('id', $request->order_id)->firstOrFail();
        return new UserOrderDetailsResource($order);
    }
}
