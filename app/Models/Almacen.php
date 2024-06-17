<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $fillable=['sucursal_id','producto_id','cantidad'];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
