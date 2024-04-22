<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GiftCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.product.gift-cards.index');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = GiftCard::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('unique_id', 'like', "%$search%")
                    ->orWhere('sender', 'like', "%$search%")
                    ->orWhere('recipient', 'like', "%$search%");
            });
        }

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id','desc')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $row = [$item->id,$item->unique_id,$item->sender,$item->senderUser->email,$item->recipient,$item->recipientUser->email,$item->amount,$item->spend,$item->exist];
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
