<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VariationType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class, 'variation_type_id', 'id');
    }
}
