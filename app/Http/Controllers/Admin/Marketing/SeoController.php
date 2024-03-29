<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.marketing.seo.index');
    }

    /**
     * save the new or existing resource.
     */
    public function store(Request $request): RedirectResponse
    {
        $title = $request->page . "_meta_title";
        $keywords = $request->page . "_meta_keywords";
        $description = $request->page . "_meta_description";

        Meta::query()->updateOrCreate([
            'type' => MetaTypes::static_page->name,
            'page' => $request->page,
        ],[
            'meta_title' => $request->$title,
            'meta_keywords' => $request->$keywords,
            'meta_description' => $request->$description
        ]);

        return Redirect::route('admin.seo.index')->with('status', 'Saved successfully!')->withFragment('#tab-'.$request->page);
    }
}
