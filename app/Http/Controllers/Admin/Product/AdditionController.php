<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\AdditionStyles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AdditionRequest;
use App\Models\Addition;
use App\Models\AdditionTypes;
use App\Services\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class AdditionController extends Controller
{
    private MediaService $imageService;
    public array $fontNames;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
        $fontCssPath = public_path('fonts/stylesheet.min.css');
        $cssContent = File::get($fontCssPath);

        // Use regular expression to extract font-family values
        preg_match_all('/@font-face\s*{\s*font-family:([^;]+);/i', $cssContent, $matches);

        $this->fontNames = array_merge(['Arial'],$matches[1]) ;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $style): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $records = AdditionTypes::query()->$style()->get();
        $styleText = AdditionStyles::getConstants()[$style];

        return view('admin.product.additions.index', compact('records', 'style', 'styleText'));
    }

    public function create(string $style): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = null;
        $styleText = AdditionStyles::getConstants()[$style];
        $fonts = $this->fontNames;

        return view('admin.product.additions.create-edit', compact('record', 'style', 'styleText', 'fonts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdditionRequest $request, string $style): RedirectResponse
    {
        $data = $request->validated();

        $type = AdditionTypes::query()->create([
            'style' => $data['style'],
            'title' => $data['title'],
        ]);

        $this->saveTemplate($type,$style,$data);
        $this->saveArts($type,$style,$request);

        return Redirect::route('admin.additions.index', ['style' => $style])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $style, string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = AdditionTypes::query()->$style()->findOrFail($id);
        $styleText = AdditionStyles::getConstants()[$style];
        $fonts = $this->fontNames;

        return view('admin.product.additions.create-edit', compact('record', 'style', 'styleText', 'fonts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdditionRequest $request, string $style, string $id): RedirectResponse
    {
        $data = $request->validated();

        $record = AdditionTypes::query()->findOrFail($id);

        $record->update([
            'title' => $data['title'],
        ]);

        $this->saveTemplate($record,$style,$data);
        $this->saveArts($record,$style,$request);

        return Redirect::route('admin.additions.index', ['style' => $style])->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $style, string $id): RedirectResponse
    {
        $record = AdditionTypes::query()->$style()->findOrFail($id);
        foreach ($record->images as $image) {
            $image->delete();
        }
        $record->delete();

        return back()->with('status', 'Removed successfully');
    }

    private function saveTemplate($record,$style,$data): void
    {
        if ($data['style'] == AdditionStyles::template->name && !empty(json_decode($data['template'],true)['objects']) && isset($data['image']) && str_contains($data['image'], ";base64,")) {
            $imageData = $data['image'];
            $imagePath = $this->imageService->dispatchFromBase64($imageData)->upload('additions/'.$style)->getUrl();
            $data['image'] = $imagePath;

            Addition::query()->create([
                'type' => $record->id,
                'image' => $data['image'],
                'template' => $data['template']
            ]);
        }
    }

    private function saveArts($record,$style,$request): void
    {
        if ($request->file('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $this->imageService->dispatch($image)->upload('additions/'.$style)->getUrl();
                $data['image'] = $imagePath;

                Addition::query()->create([
                    'type' => $record->id,
                    'image' => $data['image']
                ]);
            }
        }
    }
}
