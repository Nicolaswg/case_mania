<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable=['cantidad','nombre','photo','descripcion','categoria_id','status'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function ScopeFilterBy($query,QueryFilter $filters,array $data)
    {
        return $filters->applyTo($query,$data);
    }
}
