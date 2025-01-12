<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductoRequest extends FormRequest
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
    public function rules() //Función para validar los campos solicitados
    {
        return [
            'categoria_id'=>'required',
            'nombre'=>'required',
            'cantidad'=>'',
            'descripcion'=>'required',
            'photo'=>['required','mimes:png,jpg,jpeg'], //Solo se admite formato png, jpg, jpeg
            'sucursal_id'=>'required'

        ];
    }
}
