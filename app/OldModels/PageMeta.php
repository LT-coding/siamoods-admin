<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageMeta extends Model
{
    use HasFactory;
    protected $fillable=[
        'page_id',
        'meta_title',
        'meta_desc',
        'meta_key',
        'url'
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
