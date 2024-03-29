<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PowerLabel extends Model
{
    use HasFactory;
    protected $fillable=[
      'name','type','status','description','media','position'
    ];
}
