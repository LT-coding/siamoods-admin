<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\CartStoreRequest;
use App\Models\OrderProduct;

class CartController extends Controller
{
    public function index()
    {

    }

    public function store(CartStoreRequest $request)
    {
        $data = $request->validated();

//        OrderProduct::where('')
    }

    public function delete()
    {

    }
}
