<?php

namespace App\Services\Haysell;

use App\Models\Detail;
use App\Services\Tools\DataManager;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class DetailService
{
    private mixed $record,$meta_record;

    /**
     * @param DataManager $service
     */
    public function __construct(private readonly DataManager $service)
    {
        //
    }

    public function createOrUpdateRecord(array $items): void
    {
        foreach ($items as $item) {
            $this->createOrUpdateDetail($item);
        }
    }

    public function createOrUpdateDetail($data): void
    {
        $this->service->dataManager($data);
        DB::transaction(function () {
            try {
                $this->createDetail();
                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                throw new RuntimeException($e->getMessage());
            }
        });
    }

    private function createDetail(): void
    {
        $this->record = Detail::query()->updateOrCreate(['id'=>$this->service->detail['id']],$this->service->detail);
    }
}
