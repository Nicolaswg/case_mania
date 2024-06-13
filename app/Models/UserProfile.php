<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable=['tipo_documento','num_documento','ubicacion','num_cel','user_id','sucursal_id'];
    public function user()
    {
        return $this->belongsTo(User::class);

    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class)->withDefault();
    }


}
