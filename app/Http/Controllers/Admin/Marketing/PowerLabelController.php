<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Marketing\PowerLabelRequest;
use App\Models\PowerLabel;
use App\Services\Tools\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PowerLabelController extends Controller
{
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
        return view('admin.marketing.labels.index');
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $statuses = StatusTypes::statusList();

        return view('admin.marketing.labels.create-edit', compact('record', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PowerLabelRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($data['type'] != 0) {
            $data['media_text']['color'] = $data['media_text']['color'] ?? '#ffffff';
            $data['media_text']['background_color'] = $data['media_text']['background_color'] ?? '#0b2e7a';
            $data['media'] = json_encode($data['media_text']);
        } elseif ($request->media) {
            $imagePath = $this->imageService->dispatch($request->media)->upload('labels')->getUrl();
            $data['media'] = $imagePath;
        }

        PowerLabel::query()->create($data);

        return Redirect::route('admin.labels.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = PowerLabel::query()->findOrFail($id);
        $statuses = StatusTypes::statusList();

        return view('admin.marketing.labels.create-edit', compact('record', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PowerLabelRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = PowerLabel::query()->findOrFail($id);
        if ($data['type'] != 0) {
            $data['media_text']['color'] = $data['media_text']['color'] ?? '#ffffff';
            $data['media_text']['background_color'] = $data['media_text']['background_color'] ?? '#0b2e7a';
            $data['media'] = json_encode($data['media_text']);
        } else {
            $imagePath = $request->media
                ? $this->imageService->dispatch($request->media)->upload('labels')->getUrl()
                : $record->media;
            $data['media'] = $imagePath;
        }

        $record->update($data);

        return Redirect::route('admin.labels.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = PowerLabel::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = PowerLabel::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('id')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $type = \App\Enums\LabelType::types()[$item->type];
            $created = \Carbon\Carbon::createFromDate($item->created_at)->format('d.m.Y');
            $btnDetails = '<a href="'.route('admin.labels.edit',['label'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.labels.destroy',['label'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->name, $type, $item->status_text, $created, $btnDetails.$btnDelete];
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
