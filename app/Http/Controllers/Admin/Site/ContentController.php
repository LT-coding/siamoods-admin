<?php

namespace App\Http\Controllers\Admin\Site;

use App\Enums\ContentTypes;
use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Site\ContentRequest;
use App\Models\Content;
use App\Models\Promotion;
use App\Services\Tools\MediaService;
use App\Traits\GetRecordsTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContentController extends Controller
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
    public function index(string $type): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $typeText = ContentTypes::getConstants()[$type];
        return view('admin.site.contents.index', compact('type', 'typeText'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $type): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $typeText = ContentTypes::getConstants()[$type];
        $typeSingleText = ContentTypes::getText()[$type];

        return view('admin.site.contents.create-edit', compact('type', 'record', 'typeText', 'typeSingleText'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentRequest $request, string $type): RedirectResponse
    {
        $data = $request->validated();

        $imagePath = $request->image
            ? $this->imageService->dispatch($request->image)->upload('content/'.$type)->getUrl()
            : null;
        $data['image'] = $imagePath;

        $record = Content::query()->create([
            'type' => $type,
            'title' => $data['title'],
            'image' => $data['image'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);

        $record->meta()->create([
            'type' => MetaTypes::content->name,
            'meta_title' => $data['meta_title'],
            'meta_key' => $data['meta_keywords'],
            'meta_desc' => $data['meta_description'],
            'url' => $data['url']
        ]);

        return Redirect::route('admin.contents.index', ['type' => $type])->with('status', 'Տվյալները հաջողությամբ պահպանված են');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $type, string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Content::query()->$type()->findOrFail($id);
        $typeText = ContentTypes::getConstants()[$type];
        $typeSingleText = ContentTypes::getText()[$type];

        return view('admin.site.contents.create-edit', compact('type', 'record', 'typeText', 'typeSingleText'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentRequest $request, string $type, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = Content::query()->$type()->findOrFail($id);

        $imagePath = $request->image
            ? $this->imageService->dispatch($request->image)->upload('content/'.$type)->getUrl()
            : $record->image;
        $data['image'] = $imagePath;

        $record->update([
            'title' => $data['title'],
            'image' => $data['image'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);

        $record->meta()->update([
            'meta_title' => $data['meta_title'],
            'meta_key' => $data['meta_keywords'],
            'meta_desc' => $data['meta_description'],
            'url' => $data['url']
        ]);

        return Redirect::route('admin.contents.index', ['type' => $type])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $type, string $id): RedirectResponse
    {
        $record = Content::query()->$type()->findOrFail($id);
        $record->meta->delete();
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    public function getRecords(Request $request, string $type): JsonResponse
    {
        $query = Content::query()->$type();

        $columns = $orderColumns = ['id', 'title', 'status', 'created_at'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->orderBy('created_at','desc')->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $img = '<img src="'.$item->image_link.'" alt="image" style="max-height:100px;">';
            $createdAt = \Carbon\Carbon::parse($item->created_at)->format('m.d.Y');
            $btnView = '<a href="'.$item->url.'" class="text-olivemx-1" title="Դիտել" target="_blank"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
            $btnDetails = '<a href="'.route('admin.contents.edit',['type' => $type,'content'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.contents.destroy',['type' => $type,'content'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = $type == \App\Enums\ContentTypes::page->name
                ? [$item->id, $item->title, $item->status_text, $createdAt, $btnView.$btnDetails.$btnDelete]
                : [$item->id, $item->title, $item->status_text, $createdAt, $img, $btnView.$btnDetails.$btnDelete];
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
