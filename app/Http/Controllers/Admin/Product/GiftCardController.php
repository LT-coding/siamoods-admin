<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use App\Traits\GetRecordsTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GiftCardController extends Controller
{
    use GetRecordsTrait;

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

        $columns = ['id', 'unique_id', 'sender', 'sender_email', 'recipient', 'recipient_email', 'amount', 'spend', 'exist'];
        $orderColumns = ['id', 'unique_id', 'sender', 'sender_email', 'recipient', 'recipient_email', 'amount'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

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
