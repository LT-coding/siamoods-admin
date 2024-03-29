<?php

namespace App\Services\Haysell;

use App\Enums\MetaTypes;
use App\Models\GeneralCategory;
use App\Models\Meta;
use App\Services\Tools\DataManager;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class GeneralCategoryService
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
        $this->service->dataManager($data);
        if(!array_key_exists('deleted',$this->service->detail)) {
            DB::transaction(function () {
                try {
                    $this->createCategory();
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
        $this->record = GeneralCategory::query()->updateOrCreate(['id' => $this->service->detail['id']], $this->service->detail);
    }

    private function createCategoryMeta(): void
    {
        $this->meta_record = Meta::query()->updateOrCreate([
            'model_id' => $this->record->id,
            'type' => MetaTypes::general_cat->name
        ],$this->service->meta);
    }
}

