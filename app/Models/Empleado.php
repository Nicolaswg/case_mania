<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable=['nombre','num_cel','profesion','tipo_documento','num_documento','cargo','active'];
    use HasFactory;


}
