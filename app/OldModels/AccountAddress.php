<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountAddress extends Model
{

    const TABLE_NAME = 'account_addresses';

    protected $table = self::TABLE_NAME;

    use HasFactory;

    protected $fillable=[
        'user_id',
        'type',
        'name',
        'lastname',
        'address_1',
        'address_2',
        'country',
        'city',
        'state',
        'zip',
        'phone',
        'same_for_payment'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->name . ' ' . $this->lastname);
    }
}
