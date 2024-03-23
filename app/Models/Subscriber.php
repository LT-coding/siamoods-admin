<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable=[
        'email',
        'status'
    ];

    /**
     * User status.
     *
     * @return Attribute
     */
    protected function statusText(): Attribute
    {
        $class = $this->status == 0 ? 'text-danger' : 'text-success';
        return Attribute::make(
            get: fn () => "<span class='".$class."'>" . Status::statusNames()[$this->status]->value . "</span>"
        );
    }
}
