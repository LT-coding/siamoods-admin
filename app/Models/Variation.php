<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variation_type(): BelongsTo
    {
        return $this->belongsTo(VariationType::class, 'variation_type_id');
    }
}
