<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;
    protected $fillable=['productos','cantidad','fecha_devolucion','user','venta_id','motivo_devolucion'];
    public function venta(){
        return $this->belongsTo(Venta::class);
    }

}
