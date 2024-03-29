<?php

namespace App\OldModels;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'haysell_id',
        'name',
        'lastname',
        'email',
        'password',
        'status',
        'phone',
        'provider_id',
        'registered',
        'discount',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    public function role(): Attribute
//    {
//        return Attribute::make(get: fn($value) => $this->roles[0]['name']);
//    }

    public function isAdmin(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->hasRole(RoleType::only(['admin','developer','editor'])));
    }

    public function isAccount(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->hasRole(RoleType::only(['account'])));
    }

    public function fullName(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->name . ' ' . $this->lastname);
    }

    public function isSubscribed(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->subscription);
    }

    public function accountAddresses(): HasMany
    {
        return $this->hasMany(AccountAddress::class,'user_id','id');
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(AccountAddress::class,'user_id','id')->where('type','shipping');
    }

    public function paymentAddress(): HasOne
    {
        return $this->hasOne(AccountAddress::class,'user_id','id')->where('type','payment');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscriber::class,'email','email')->where('status','1');
    }
}
