<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\ShippingMethodRequest;
use App\Models\ShippingMethod;
use App\Services\Tools\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ShippingMethodController extends Controller
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
        $records = ShippingMethod::query()->get();

        return view('admin.order.shipping-methods.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;

        return view('admin.order.shipping-methods.create-edit', compact('record'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingMethodRequest $request): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        $imagePath = $this->imageService->dispatch($request->file('image'))->upload('shipping'.$data['title'])->getUrl();

        $record = ShippingMethod::query()->create([
            'title' => $data['title'],
            'image' => $imagePath,
        ]);

        if ($request->prices) {
            $this->savePrices($record,$data);
        }

        return Redirect::route('admin.shipping-methods.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = ShippingMethod::query()->findOrFail($id);

        return view('admin.order.shipping-methods.create-edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingMethodRequest $request, string $id): RedirectResponse|JsonResponse
    {
        $data = $request->validated();
        $record = ShippingMethod::query()->findOrFail($id);

        $imagePath = $request->file('image')
            ? $this->imageService->dispatch($request->file('image'))->upload('shipping'.$record->title)->getUrl()
            : $record->image;

        $record->update([
            'title' => $data['title'],
            'image' => $imagePath,
        ]);

        if ($request->prices) {
            $this->savePrices($record,$data);
        }

        return Redirect::route('admin.shipping-methods.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = ShippingMethod::query()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Removed successfully');
    }

    private function savePrices($record, $data): void
    {
        foreach ($data['prices'] as $key => $val) {
            $count = $data['price_from_counts'][$key] ?? 1;
            if ($val) {
                $record->prices()->updateOrCreate([
                    'price_from_count' => $count
                ],[
                    'price' => $data['prices'][$key],
                ]);
            }
        }
    }
}
