<?php

namespace App\Models\filters;

use App\Models\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryFilter extends QueryFilter
{
    use HasFactory;

    public function rules()
    {
         return[
             'search' => 'filled',
             'status' => 'filled',
         ];
    }
    public function search($query,$value)
    {
        return $query->where(function ($query) use ($value){
            $query->whereHas('venta.cliente',function ($query) use ($value){
                $query->where('nombre', 'like', "%{$value}%")
                    ->orWhere('num_documento','like', "%{$value}%");
            });
        }) ;
    }
    public function status($query,$value)
    {
        return $query->where(function ($query) use ($value) {
            $query->where('status', $value);

        });
    }

}
