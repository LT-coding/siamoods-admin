<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GetRecordsTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use GetRecordsTrait;

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = User::query()->accounts()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = User::query()->accounts();

        $columns = ['id', 'name', 'lastname', 'phone', 'email', 'created_at'];
        $orderColumns = ['id', 'name', 'phone', 'email', 'created_at'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $email = '<a href="mailto:"'.$item->email.'>'.$item->email.'</a>';
//            $btnDetails = '<a href="'.route('admin.accounts.show',['account'=>$item->id]).'" class="text-info mx-1" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.accounts.destroy',['account'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->full_name, $item->phone, $email, $item->registered, $btnDelete];
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
