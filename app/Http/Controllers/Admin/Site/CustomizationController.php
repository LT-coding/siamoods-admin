<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Site\CustomizationRequest;
use App\Models\Customization;
use App\Models\SocialMedia;
use App\Services\Tools\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomizationController extends Controller
{
    private MediaService $imageService;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $socials = SocialMedia::query()->get();

        return view('admin.site.customization.index', compact(['socials']));
    }

    public function socials(String $i): array
    {
        $social = null;

        return ['view' => view('admin.site.customization.social', compact(['social','i']))->render()];
    }

    public function update(CustomizationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if(array_key_exists('socials',$data['1'])){
            $socials = $data['1']['socials'];
            $this->updateSocials($socials);
        }
        unset($data['1']['socials']);
        $this->updateRecords(array_except($data,['page']));

        return Redirect::route('admin.customization.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են')->withFragment('#tab-'.$request->page);
    }

    private function updateSocials($socials): void
    {
        foreach ($socials as $social)
        {
            if (array_key_exists('image',$social)) {
                $imagePath = $this->imageService->dispatch($social['image'])->upload('customization')->getUrl();
                $social['image'] = $imagePath;
                SocialMedia::query()->updateOrCreate([
                    'url' => $social['url']
                ],$social);
            }
        }
    }

    private function updateRecords($data): void
    {
        foreach ($data as $key => $items) {
            $record['position'] = $key;
            foreach ($items as $p => $item) {
                $record['type'] = $p;
                foreach ($item as $n => $elem) {
                    $record['name'] = $n;
                    if (!is_null($elem)) {
                        if (is_string($elem)) {
                            $record['value'] = $elem;
                        } else {
                            $imagePath = $this->imageService->dispatch($elem)->upload('customization')->getUrl();
                            $record['value'] = $imagePath;
                        }
                    } else {
                        $record['value'] = null;
                    }
                    Customization::query()->updateOrCreate([
                        'position' => $record['position'],
                        'type' => $record['type'],
                        'name' => $record['name']
                    ],$record);
                }
            }
        }
    }
}
