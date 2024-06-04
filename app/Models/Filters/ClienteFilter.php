<?php

namespace App\Models\filters;

use App\Models\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClienteFilter extends QueryFilter
{
    use HasFactory;

    public function rules()
    {
       return [
           'search' => 'filled',
           'status' => 'in:active,inactive',
           'order'=>['regex:/^(nombre)(-desc)?$/'],
       ];
    }
    public function state( $query,$state){

        return $query->where('status', $state=='active');

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
    public function search($query,$search)
    {
        return $query->where(function ($query) use ($search){
            $query->where('nombre', 'like', "%{$search}%")
                ->orwhere('num_documento', 'like', "%{$search}%");
        });

    }

}
