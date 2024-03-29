<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
{
    use HasFactory;
    protected $fillable=[
            'name',
            'description',
            'parent_page',
            'position',
            'status',
    ];

    public function meta(): HasOne
    {
        return $this->hasOne(PageMeta::class,'page_id','id');
    }
}
