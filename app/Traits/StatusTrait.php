<?php

namespace App\Traits;

use App\Enums\StatusTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait StatusTrait
{
    public function scopeActive(Builder $query): void
    {
        $query->where('status', StatusTypes::active->value);
    }

    /**
     * status text.
     *
     * @return Attribute
     */
    protected function statusText(): Attribute
    {
        $class = $this->status == 0 ? 'text-danger' : 'text-success';
        return Attribute::make(
            get: fn () => "<small class='".$class."'>" . StatusTypes::statusList()[$this->status] . "</small>"
        );
    }
}
