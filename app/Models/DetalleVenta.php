<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    protected $fillable=[
        'venta_id',
        'productos_nombres',
        'categorias_productos',
        'productos_ids',
        'cantidad',
        'costo_unitario',
        'subtotal',
        'photos',
    ];
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
