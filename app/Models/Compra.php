<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $casts = [
        'status_carga'=>'bool',
    ];
    use HasFactory;
    protected $fillable=['proveedor_id','status_carga','fecha_compra','subtotal','iva','total','tasa_bcv','sucursal_id'];
    public function detalle_compra()
    {
        return $this->hasOne(DetalleCompra::class);
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
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
