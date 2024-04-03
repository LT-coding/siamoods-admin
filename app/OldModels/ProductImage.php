<?php

namespace App\OldModels;

use App\Enums\RoleType;
use App\Services\Tools\MediaService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable=[
        'haysell_id',
        'product_id',
        'image',
        'image_path',
        'is_general'
    ];

//    public function image(): Attribute
//    {
//        $webp = (new MediaService())->getWebp($this->image_path);
//        return Attribute::make(get: fn($value) => $this->image_path && $webp ? $webp : $value);
//    }
}
