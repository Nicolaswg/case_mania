<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioTecnico extends Model
{
    use HasFactory;
    protected $fillable=['fecha_recibido','serial','falla','cliente_id','productos','cantidad','user','status','costo_dolar','costo_bolivar'];
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }

}
