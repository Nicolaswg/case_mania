<?php

namespace App\Models\filters;

use App\Models\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CompraFilter extends QueryFilter
{
    use HasFactory;

    public function rules()
    {
        return[
            'search' => 'filled',
            'proveedor'=>'filled',
            'order'=>['regex:/^(fecha_compra)(-desc)?$/'],
        ];

    }
    public function search($query,$search)
    {
        return $query->where(function ($query) use ($search){
            $query->wherehas('detalle_compra',function ($q) use ($search){
                $q->where('productos_nombres','like', "%{$search}%");
            });
        });

    }
    public function proveedor($query,$proveedor)
    {
        return $query->where(function ($query) use ($proveedor){
            $query->whereHas('proveedor',function ($q) use ($proveedor){
                $q->where('id',$proveedor);
            });
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
