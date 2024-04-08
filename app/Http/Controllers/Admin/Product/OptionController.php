<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\OptionRequest;
use App\Models\Option;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class OptionController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $records = Option::query()->notColor()->orderBy('created_at','desc')->get();

        return view('admin.product.options.index', compact('records'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;

        return view('admin.product.options.create-edit', compact('record'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OptionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['code'] = str_slug($data['title'],'-');
        $data['show_in_filter'] = $data['show_in_filter'] ?? 0;
        if (Option::query()->where('code',$data['code'])->first()) {
            return back()->withErrors(['code' => 'The Option with the same title already exists'])->withInput();
        }
        Option::query()->create($data);

        return Redirect::route('admin.options.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Option::query()->findOrFail($id);

        return view('admin.product.options.create-edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OptionRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = Option::query()->findOrFail($id);
        $data['code'] = str_slug($data['title'],'-');
        $data['show_in_filter'] = $data['show_in_filter'] ?? 0;
        if (Option::query()->where('code',$data['code'])->where('id','!=',$id)->first()) {
            return back()->withErrors(['code' => 'The Option with the same title already exists'])->withInput();
        }
        $record->update($data);

        return Redirect::route('admin.options.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = Option::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }
}
