<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const ROLE_SHIPPER  = 'shipper';
    const ROLE_ADMIN    = 'admin';
    const ROLE_CUSTOMER = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'latitude',
        'longitude',
        'role_type',
        'email_verified_at',
        'password',
        'token'
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
    //mutator
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] =  strtolower($email);
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function postages()
    {
        return $this->hasMany(PostageManagement::class, 'shipper_user_id', 'id');
    }
}
