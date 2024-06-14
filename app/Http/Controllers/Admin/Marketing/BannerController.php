<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Marketing\BannerRequest;
use App\Models\Banner;
use App\Services\Tools\MediaService;
use App\Traits\GetRecordsTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{
    use GetRecordsTrait;

    private MediaService $imageService;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.marketing.banners.index');
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $statuses = StatusTypes::statusList();

        return view('admin.marketing.banners.create-edit', compact('record', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $imagePath = $this->imageService->dispatch($request->image)->upload('banners')->getUrl();
        $data['image'] = $imagePath;

        Banner::query()->create($data);

        return Redirect::route('admin.banners.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Banner::query()->findOrFail($id);
        $statuses = StatusTypes::statusList();

        return view('admin.marketing.banners.create-edit', compact('record', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = Banner::query()->findOrFail($id);

        $imagePath = $request->image
            ? $this->imageService->dispatch($request->image)->upload('banners')->getUrl()
            : $record->image;
        $data['image'] = $imagePath;

        $record->update($data);

        return Redirect::route('admin.banners.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Banner::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = Banner::query();

        $columns = $orderColumns = ['id', 'name', 'status', 'created_at'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $img = '<img src="'.$item->image_link.'" alt="image" style="max-height:100px;">';
            $created = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d.m.Y');
            $btnDetails = '<a href="'.route('admin.banners.edit', ['banner' => $item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.banners.destroy', ['banner' => $item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->name, $item->status_text, $created, $img, $btnDetails.$btnDelete];
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
