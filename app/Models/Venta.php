<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable=[
        'cliente_id',
        'sucursal_id',
        'fecha_venta',
        'tasa_bcv',
        'subtotal_dolar',
        'iva_dolar',
        'total_dolar',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    public function detalle_venta()
    {
        return $this->hasOne(DetalleVenta::class);
    }
    public function delivery()
    {
        return $this->hasOne(Delivery::class)->withDefault();
    }
    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }


}
