<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Marketing\PromotionRequest;
use App\Models\Promotion;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $records = Promotion::query()->get();

        return view('admin.marketing.promotions.index', compact('records'));
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
}
