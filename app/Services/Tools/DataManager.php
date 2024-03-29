<?php

namespace App\Services\Tools;

class DataManager
{
    public array $meta_trans=[],$detail_trans=[],$meta,$detail;
    public function dataManager($data): void
    {
        foreach ($data as $key => $item){
            if (str_contains($key,'meta')&&(str_contains($key,'_en')||str_contains($key,'_ru'))) {
                $this->meta_trans[$key] = $item;
            } else if (str_contains($key,'_en')||str_contains($key,'_ru')) {
                $this->detail_trans[$key] = $item;
            } else if (str_contains($key,'meta')) {
                $this->meta[$key] = $item;
            } else {
                $this->detail[$key] = $item;
            }
        }
    }
}
