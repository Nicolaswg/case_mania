<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguridad extends Model
{
    use HasFactory;
    protected $fillable=['pregunta_1','pregunta_2','respuesta_1','respuesta_2'];

    public function user()//Perfiles de Usuarios
    {
        return $this->belongsTo(User::class);
    }

}
