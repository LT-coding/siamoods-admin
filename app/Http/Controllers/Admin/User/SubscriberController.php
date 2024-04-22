<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.user.subscribers.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $record = Subscriber::query()->findOrFail($id);
        $record->update([
            'status' => $request->status
        ]);
        if($request->ajax()){
            return response()->json([
                'status' => 'success',
            ], 200);
        }

        return Redirect::route('admin.subscribers.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = Subscriber::query();

        if ($request->active) {
            $query->active();
        }

        $statuses = StatusTypes::statusList();

        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%$search%");
            });
        }

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id', 'desc')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $statusSelect = '<select name="status" class="form-control status-change" data-id="'.$item->id.'">';
            foreach ($statuses as $key => $value) {
                $selected = $key == $item->status ? 'selected' : '';
                $statusSelect .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
            }
            $statusSelect .= '</select>';

            $row = [$item->id, $item->email, $statusSelect];
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
