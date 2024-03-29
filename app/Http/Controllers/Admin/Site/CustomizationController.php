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
use Illuminate\Http\Request;

class CustomizationController extends Controller
{
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

    public function update(CustomizationRequest $request){
        $data=$request->validated();

        if(array_key_exists('socials',$data['1'])){
            $socials=$data['1']['socials'];
            $this->updateSocials($socials);
        }
        unset($data['1']['socials']);
        $this->updateRecords($data);

        return redirect()->route('admin.customization.index');
    }

    private function updateSocials($socials){
        foreach ($socials as $social)
        {
            if(array_key_exists('image',$social)){
                if(!is_null($social['image'])){
                    $uploader = (new MediaService)->apply($social['image'], "customization");
                    $social['image'] = asset($uploader->path());
                    SocialMedia::updateOrCreate([
                        'url'=>$social['url']
                    ],$social);
                }
            }
        }
    }

    private function updateRecords($data): void
    {
        foreach ($data as $key=>$items){
            $record['position']=$key;
            foreach ($items as $p=>$item){
                $record['type']=$p;
                foreach ($item as $n=>$elem){
                    $record['name']=$n;
                    if(!is_null($elem)){
                        if(is_string($elem)){
                            $record['value']=$elem;
                        }else{
                            $uploader = (new MediaService)->apply($elem, "customization");
                            $record['value'] = asset($uploader->path());
                        }
                        Customization::updateOrCreate([
                            'position'=>$record['position'],
                            'type'=>$record['type'],
                            'name'=>$record['name']
                        ],$record);
                    }else{
                        $record['value']=null;
                        Customization::updateOrCreate([
                            'position'=>$record['position'],
                            'type'=>$record['type'],
                            'name'=>$record['name']
                        ],$record);
                    }
                }
            }
        }
    }
}
