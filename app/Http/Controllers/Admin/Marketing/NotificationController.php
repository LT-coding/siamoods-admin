<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Marketing\NotificationRequest;
use App\Models\Notification;
use App\Models\Subscriber;
use App\Traits\GetRecordsTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class NotificationController extends Controller
{
    use GetRecordsTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.marketing.notifications.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Notification::query()->findOrFail($id);
        $types = Notification::TYPES;

        return view('admin.marketing.notifications.create-edit', compact('record', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = Notification::query()->findOrFail($id);
        $record->update(array_except($data,['send']));

        if($request->send){
            $subscribers = Subscriber::query()->where('status',StatusTypes::active)->get();
            foreach ($subscribers as $sub){
                Mail::to($sub->email)->send(new SendCustomMail());
            }
        }

        return Redirect::route('admin.notifications.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = Notification::query();
        $types = Notification::TYPES;

        $columns = $orderColumns = ['id', 'title', 'text'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $btnDetails = '<a href="'.route('admin.notifications.edit',['notification'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $row = [$item->id, $item->title, $item->text, $types[$item->type], $btnDetails];
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
