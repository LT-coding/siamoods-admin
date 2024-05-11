<?php

namespace App\Models;

use App\Enums\Country;
use App\Enums\State;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->name . ' ' . $this->lastname);
    }

    public function fullAddress(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->address_1 . '<br> ' . $this->city . ', ' . State::getConstants()[$this->state]->value . ' ' . $this->zip . ', ' . Country::getConstants()[$this->country]->value);
    }
}
