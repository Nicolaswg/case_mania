<?php

namespace App\Models\filters;

use App\Models\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioFilter extends QueryFilter
{
    use HasFactory;

    public function rules()
    {
        return [
            'search' => 'filled',
        ];
    }
    public function search($query,$search)
    {
        return $query->where(function ($query) use ($search){
            $query->whereHas('cliente',function ($q) use ($search){
                $q->where('nombre', 'like', "%{$search}%")
                    ->orwhere('num_documento', 'like', "%{$search}%");
            });
        });

    }

}
