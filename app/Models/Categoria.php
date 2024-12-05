<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable=['nombre','active'];
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    public function proveedores()
    {
        return $this->hasMany(Proveedor::class);
    }
    public function setStateAttribute($value){
        $this->attributes['active'] = $value=='active';
    }
    public function getStateAttribute()
    {
        if($this->active !== null) {
            return $this->active ? 'active' : 'inactive';
        }

    }

}
