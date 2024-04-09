<?php

namespace App\Traits;

use App\Services\Tools\MediaService;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ImageLinkTrait
{
    public function imageLink(): Attribute
    {
        $columnName = $this->getImageColumnName();

        return Attribute::make(get: fn() => (new MediaService())->getWebp($this->{$columnName}));
    }

    protected function getImageColumnName(): string
    {
        $possibleColumnNames = ['image', 'media'];

        foreach ($possibleColumnNames as $columnName) {
            if (!in_array($columnName, $this->guarded)) {
                return $columnName;
            }
        }

        return 'image';
    }
}
