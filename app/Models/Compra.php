<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable=['proveedor_id','fecha_compra','subtotal','iva','total'];
    public function detalle_compra()
    {
        return $this->hasOne(DetalleCompra::class);
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }

}
