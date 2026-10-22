<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;

class User extends AuthenticatableUser
{
    use Authenticatable, Authorizable, CanResetPassword, HasRoles, Impersonate, Notifiable, SoftDeletes;

    /**
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'scockpit_user_id', 'sex', 'title', 'job_title', 'birthdate', 'position', 'phone', 'mobile', 'notes', 'api_token', 'phone', 'mobil_phone', 'first_name', 'last_name', 'categorie_id', 'salutation', 'customer_id', 'verified_at', 'password', 'last_logon',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['api_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    /**
     * @return mixed
     */
    public function userCategories(): HasOne
    {
        return $this->hasOne(UserCategories::class, 'id', 'categorie_id');
    }

    /**
     * @param  string  $search
     */
    public function scopeCustomSearch(Builder $query, $search)
    {
        $query
            ->where('id', 'LIKE', '%'.$search.'%')
            ->orWhere('name', 'LIKE', '%'.$search.'%');
    }

    public function scopeSearch(Builder $query, string $search)
    {
        $query->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%');
    }

    public function getUserPermissionsAttribute()
    {
        return $this->getAllPermissions()->map(function ($permission) {
            return $permission->name;
        });
    }
}
