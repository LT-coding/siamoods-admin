<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'image',
        'status',
        'from',
        'to'
    ];

    public function meta(): HasOne
    {
        return $this->hasOne(BlogMeta::class,'blog_id','id');
    }

    public function getUrlAttribute()
    {
        return route('site.blog_item',['blog' => $this->meta->url]);
    }
}
