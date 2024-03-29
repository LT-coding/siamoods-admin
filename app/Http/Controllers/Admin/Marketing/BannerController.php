<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Site\BannerRequest;
use App\Models\Banner;
use App\Services\Tools\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
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
        $records = Banner::query()->get();

        return view('admin.marketing.banners.index', compact('records'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;

        return view('admin.marketing.banners.create-edit', compact('record'));
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

        return Redirect::route('admin.banners.index')->with('status', 'Saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Banner::query()->findOrFail($id);

        return view('admin.marketing.banners.create-edit', compact('record'));
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

        return Redirect::route('admin.banners.index')->with('status', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Banner::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Removed successfully');
    }
}
