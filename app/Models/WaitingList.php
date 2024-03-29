<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{

    const TABLE_NAME = 'waiting_lists';

    protected $table = self::TABLE_NAME;

    use HasFactory;
    protected $fillable=[
        'email',
        'product_id','haysell_id'
    ];

    public function product(){
        return $this->HasOne(Product::class,'id','product_id');
    }
}
