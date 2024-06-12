<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $fillable=['codigo','nombre','estado','ciudad'];
    public function users()
    {
        return $this->hasMany(UserProfile::class);
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

}
