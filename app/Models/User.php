<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleType;
use App\Enums\Status;
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
        'id',
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
            get: fn () => RoleType::getConstants()[$this->getRoleNames()[0]]
        );
    }

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

    public function scopeAccounts(Builder $query): void
    {
        $query->role(RoleType::account->name);
    }

    public function scopeAdmins(Builder $query): void
    {
        $query->role(RoleType::adminRoles());
    }
}
