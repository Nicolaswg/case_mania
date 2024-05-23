<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable=['nombre','rif','status','num_cel'];
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
