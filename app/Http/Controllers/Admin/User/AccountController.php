<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.user.accounts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = User::query()->accounts()->findOrFail($id);

        return view('admin.user.accounts.show', compact('record'));
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = User::query()->accounts()->orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('lastname', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id', 'desc')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $email = '<a href="mailto:"'.$item->email.'>'.$item->email.'</a>';
//            $btnDetails = '<a href="'.route('admin.accounts.show',['account'=>$item->id]).'" class="text-info mx-1" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $row = [$item->id, $item->full_name, $item->phone, $email, $item->registered];
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
