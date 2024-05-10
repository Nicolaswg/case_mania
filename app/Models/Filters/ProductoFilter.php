<?php

namespace App\Models\Filters;

use App\Models\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductoFilter extends QueryFilter
{
    use HasFactory;

    public function rules()
    {
        return [
            'search' => 'filled',
            'categoria'=>'filled',
            'order'=>['regex:/^(nombre)(-desc)?$/'],
        ];
    }
    public function search($query,$search)
    {
        return $query->where(function ($query) use ($search){
            $query->where('nombre', 'like', "%{$search}%")
                ->orwhere('descripcion', 'like', "%{$search}%");

        });

    }
    public function categoria($query,$categoria){
        return $query->where(function ($query) use ($categoria){
            $query->whereHas('categoria',function ($q) use ($categoria){
                $q->where('id',$categoria);
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
