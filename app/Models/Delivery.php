<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable=['direccion','fecha_entrega','detalles_entrega','costo_delivery','referencia','venta_id','user_id','status'];
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }
}
