<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductPrice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'haysell_id', 'id');
    }
}
