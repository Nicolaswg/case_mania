<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable=['cantidad','tasa_bcv','cantidad_devueltos','nombre','photo','descripcion','categoria_id','status','precio_compra','porcentaje_ganancia','precio_venta','sucursal_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }
}
