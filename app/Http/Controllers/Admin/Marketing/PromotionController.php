<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Marketing\PromotionRequest;
use App\Models\Promotion;
use App\Traits\GetRecordsTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PromotionController extends Controller
{
    use GetRecordsTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.marketing.promotions.index');
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $statuses = StatusTypes::statusList();

        return view('admin.marketing.promotions.create-edit', compact('record', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromotionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Promotion::query()->create($data);

        return Redirect::route('admin.promotions.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Promotion::query()->findOrFail($id);
        $statuses = StatusTypes::statusList();

        return view('admin.marketing.promotions.create-edit', compact('record', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromotionRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = Promotion::query()->findOrFail($id);
        $record->update($data);

        return Redirect::route('admin.promotions.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Promotion::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = Promotion::query();

        $columns = $orderColumns = ['id', 'name', 'promo_code', 'status', 'created_at'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $type = \App\Enums\PromotionType::promotions()[$item->type];
            $created = \Carbon\Carbon::createFromDate($item->created_at)->format('d.m.Y');
            $btnDetails = '<a href="'.route('admin.promotions.edit',['promotion'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = $item->promo_code == 'ABCARD5' ? '' : '<a href="#" data-action="'.route('admin.promotions.destroy',['promotion'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->name, $item->promo_code, $item->status_text, $created, $type, $btnDetails.$btnDelete];
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
