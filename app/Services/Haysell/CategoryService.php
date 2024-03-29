<?php

namespace App\Services\Haysell;

use App\Enums\MetaTypes;
use App\Models\Category;
use App\Models\Meta;
use App\Services\Tools\DataManager;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class CategoryService
{
    private mixed $record, $meta_record;

    /**
     * @param DataManager $service
     */
    public function __construct(private readonly DataManager $service)
    {
        //
    }

    public function createOrUpdateRecord(array $items): void
    {
        foreach ($items as $item){
            $this->createOrUpdateCategory($item);
        }
    }

    public function createOrUpdateCategory($data): void
    {
        if(!array_key_exists('status',$data)){
            $data['status'] = $data['active'];
        }
        $data['general_category_id']=$data['cat_id'];
        $this->service->dataManager($data);
        if($this->service->detail['deleted']==0){
            DB::transaction(function () {
                try {
                    $this->createCategory();
                    $this->createCategoryMeta();
                    DB::commit();
                } catch (Throwable $e) {
                    DB::rollBack();
                    throw new RuntimeException($e->getMessage());
                }
            });
        }
    }

    private function createCategory(): void
    {
        if (array_key_exists('id',$this->service->detail)) {
            $this->record = Category::query()->updateOrCreate(['id'=>$this->service->detail['id']],$this->service->detail);
        } else {
            $this->record = Category::query()->create($this->service->detail);
        }
    }

    private function createCategoryMeta(): void
    {
        $this->meta_record = Meta::query()->updateOrCreate([
            'model_id' => $this->record->id,
            'type' => MetaTypes::product->name
        ],$this->service->meta);
    }
}
