<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\OrderStatusEnum;
use App\Enums\RoleTypes;
use App\Notifications\CustomResetPasswordNotification;
use App\Notifications\CustomVerifyEmailNotification;
use App\Traits\StatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
    use HasApiTokens, HasFactory, Notifiable, HasRoles, StatusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
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
        'password' => 'hashed',
    ];

    /**
     * Send the custom password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    /**
     * Send the custom email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmailNotification());
    }

    /**
     * User Full Name.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name . ' ' . $this->lastname
        );
    }

    /**
     * User Full Name.
     *
     * @return Attribute
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => (!$this->name && !$this->lastname) ? $this->email : $this->name . ' ' . $this->lastname
        );
    }

    /**
     * User Role Name.
     *
     * @return Attribute
     */
    protected function roleName(): Attribute
    {
        return Attribute::make(
            get: fn () => RoleTypes::getConstants()[$this->getRoleNames()[0]]
        );
    }

    /**
     * User Full Name.
     *
     * @return Attribute
     */
    protected function registered(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->created_at)->format('d.m.Y')
        );
    }

    /**
     * Check if this user is Account.
     *
     * @return Attribute
     */
    protected function isAccount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(RoleTypes::account->name)
        );
    }

    public function scopeAccounts(Builder $query): void
    {
        $query->role(RoleTypes::account->name);
    }

    public function scopeAdmins(Builder $query): void
    {
        $query->role(RoleTypes::adminRoles());
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscriber::class, 'email', 'email');
    }

    public function addresses(): HasMany
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

    public function favorites(): HasMany
    {
        return $this->hasMany(WishingList::class,'user_id','id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id','id')->whereNotIn('status',[OrderStatusEnum::CANCELED,OrderStatusEnum::NOT_COMPLETED,OrderStatusEnum::UNDEFINED])->orderBy('created_at', 'desc');
    }

    public function updateSubscrption($s): void
    {
        if ($this->subscription || $s) {
            $this->subscription()->updateOrCreate(['email' => $this->email], ['status' => $s]);
        }
    }
}
