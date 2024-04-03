<?php

namespace App\Http\Controllers\Admin\Site;

use App\Enums\ContentTypes;
use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Site\ContentRequest;
use App\Models\Content;
use App\Services\Tools\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ContentController extends Controller
{
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
        $records = Content::query()->$type()->orderBy('created_at','desc')->get();
        $typeText = ContentTypes::getConstants()[$type];

        return view('admin.site.contents.index', compact('type', 'records', 'typeText'));
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
            'type' => MetaTypes::getConstants()[$type]->name,
            'meta_title' => $data['meta_title'],
            'meta_key' => $data['meta_keywords'],
            'meta_desc' => $data['meta_description'],
            'url' => $data['url']
        ]);

        return Redirect::route('admin.contents.index', ['type' => $type])->with('status', 'Saved successfully');

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

        return Redirect::route('admin.contents.index', ['type' => $type])->with('status', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $type, string $id): RedirectResponse
    {
        $record = Content::query()->$type()->findOrFail($id);
        $record->meta->delete();
        $record->delete();

        return back()->with('status', 'Removed successfully');
    }
}
