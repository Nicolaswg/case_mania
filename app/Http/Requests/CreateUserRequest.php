<?php

namespace App\Http\Requests;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required','unique:users,email','email:rfc'],
            'password' => 'required',
            'role' => ['required'],
            'ubicacion'=>['required'],
            'num_cel'=>['required'],
            'sucursal_id'=>['required'],
            'state'=>[Rule::in(['active','inactive'])],
            'tipo_documento'=>'required',
            'num_documento'=>['required',Rule::unique('user_profiles','num_documento')],
            'pregunta_1'=>'required',
            'pregunta_2'=>'required',
            'respuesta_1'=>'required',
            'respuesta_2'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre y apellido es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            /* 'password.required' => 'La contraseña es obligatoria', */
            'ubicacion.required' => 'La dirección de domicilio es obligatoria',
            'tipo_documento.required'=>'El tipo de documento es obligatorio',
            'num_documento.required'=>'El número de documento es obligatorio',
            'num_cel.required'=>'El número de teléfono es obligatorio',
            'sucursal_id.required'=>'La sucursal es obligatoria',
            'role.required'=>'El usuario debe tener un Rol de acceso'      
        ];
    }
    public function createUser() //Función para crear el usuario
    {
            DB::transaction(function () {
                $user = User::create([
                    'name' => $this->input('name'),
                    'email' => $this->input('email'),
                    'password' => bcrypt($this->input('password')),
                    'role' => $this->input('role' ),
                    'state'=>$this->input('state')
                ]);

                $user->save();
                $user->profile()->create([
                    'ubicacion'=>$this->input('ubicacion'),
                    'num_cel'=>$this->input('num_cel'),
                    'tipo_documento'=>$this->input('tipo_documento'),
                    'num_documento'=>$this->input('num_documento'),
                    'sucursal_id'=>$this->input('sucursal_id'),
                ]);
                $user->seguridad()->create([
                    'pregunta_1'=>$this->input('pregunta_1'),
                    'pregunta_2'=>$this->input('pregunta_2'),
                    'respuesta_1'=>$this->input('respuesta_1'),
                    'respuesta_2'=>$this->input('respuesta_2'),
                ]);

            });



    }

}
