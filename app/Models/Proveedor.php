<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable=['nombre','rif','status','num_cel','tipo','categoria_id'];
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }

}
