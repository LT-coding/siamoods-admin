<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'haysell_id','haysell_id');
    }
}
