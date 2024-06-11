<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable=['nombre','direccion','tipo_documento','num_documento','telefono','email','status'];
    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }
    public function ventas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Venta::class);
    }
    public function servicio(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ServicioTecnico::class);
    }

}
