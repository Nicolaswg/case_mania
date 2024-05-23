<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $fillable=['compra_id','productos_nombres','productos_ids','cantidad','costo_unitario','subtotal','photos','categorias_productos'];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
}
