<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [ //Función para validar los campos solicitados
            'categoria_id'=>'required',
            'nombre'=>'required',
            'cantidad'=>'',
            'descripcion'=>'required',
            'photo'=>'',
        ];
    }
}
