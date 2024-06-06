<?php

namespace App\Models\Filters;

use App\Models\QueryFilter;
use Illuminate\Support\Str;


class UserFilter extends QueryFilter
{
    protected $aliases= [
        'date'=>'created_at',
    ];


    public function rules(): array
    {
        return [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,vendedor,servicio,delivery',
            'order'=>['regex:/^(name|email)(-desc)?$/'],
        ];
    }
    public function search($query,$search)
    {
        return $query->where(function ($query) use ($search){
            $query->where('name', 'like', "%{$search}%")
                ->orwhere('email', 'like', "%{$search}%")
                ->orwherehas('profile',function ($query) use ($search){
                    $query->where('num_documento','like',"%{$search}%");
                });

        });

    }
    public function state( $query,$state){

        return $query->where('active', $state=='active');

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
