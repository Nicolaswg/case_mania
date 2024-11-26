<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login',
        'active'
    ];
    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault();
    }
    public function delivery()
    {
        return $this->hasMany(Delivery::class);
    }
    public function seguridad()//seguridad
    {
        return $this->hasOne(Seguridad::class)->withDefault();
    }
    public function isAdmin(){
        return $this->role === 'admin';
    }
    public function isDelivery(){
        return $this->role === 'delivery';
    }
    public function isVendedor(){
        return $this->role === 'vendedor';
    }
    public function isServicio(){
        return $this->role === 'servicio';
    }
    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }

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
}
