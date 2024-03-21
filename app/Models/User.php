<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * User Full Name.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name . ' ' . $this->last_name
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
            get: fn () => (!$this->first_name && !$this->last_name) ? $this->email : $this->first_name . ' ' . $this->last_name
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
            get: fn () => $this->getRoleNames()[0]
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
            get: fn () => Carbon::parse($this->created_at)->format('m/d/Y')
        );
    }

    /**
     * Check if this user is Super Admin.
     *
     * @return Attribute
     */
    protected function isSuperAdmin(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(RoleType::super_admin->value)
        );
    }

    /**
     * Check if this user is Admin.
     *
     * @return Attribute
     */
    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(RoleType::admin->value)
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
            get: fn () => $this->hasRole(RoleType::account->value)
        );
    }

    public function scopeAccounts(Builder $query): void
    {
        $query->role(RoleType::account->value);
    }

    public function scopeAdmins(Builder $query): void
    {
        $query->role(RoleType::adminRoles());
    }
}
