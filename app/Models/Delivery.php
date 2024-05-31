<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable=['direccion','costo_delivery','referencia','venta_id','status'];
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
