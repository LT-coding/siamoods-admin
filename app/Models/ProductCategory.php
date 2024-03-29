<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{

    const TABLE_NAME = 'product_categories';

    protected $table = self::TABLE_NAME;
    use HasFactory;
    protected $fillable=[
        'product_id',
        'category_id',
        'general_category_id',
        'haysell_id',
        'type'
    ];
}
