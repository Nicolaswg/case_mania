<?php

namespace App\Models\filters;

use App\Models\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VentaFilter extends QueryFilter
{
    use HasFactory;

    public function rules()
    {
        return [
            'search'=>'filled',
            'sucursal'=>'filled',
            'delivery'=>'',
            'order'=>['regex:/^(fecha_venta)(-desc)?$/'],
        ];

    }
    public function delivery($query,$value){

        return $query->where(function ($query) use ($value){
            $query->whereHas('delivery',function ($query) use ($value){
                $query->where('status',$value);
            });
        }) ;


    }
    public function search($query,$search)
    {
        return $query->wherehas('cliente',function ($q) use ($search){
            $q->where('nombre','like', "%{$search}%")
            ->orWhere('num_documento','like', "%{$search}%");
        })->orwherehas('detalle_venta',function ($q) use ($search){
            $q->where('productos_nombres','like', "%{$search}%");
        });

    }
    public function sucursal($query,$value){
        return $query->whereHas('sucursal',function ($q) use ($value){
            $q->where('id',$value);
        });
    }
    public function order($query,$value){

        if(Str::endsWith($value,'-desc')){
            $query->orderByDesc($this->getColumnName(Str::substr($value,0,-5)));
        }else{
            $query->orderBy($this->getColumnName($value));
        }


    }
    private function getColumnName($value): string
    {

        return $this->aliases[$value] ?? $value;
    }

}
