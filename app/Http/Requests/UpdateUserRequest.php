<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;



class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [ //Función para validar los campos solicitados
            'name' => 'required',
            'email' => ['required',Rule::unique('users','email')->ignore($this->user),'email:rfc'],
            'password' => 'required',
            'role' => ['required'],
            'ubicacion'=>['required'],
            'sucursal_id'=>'required',
            'num_cel'=>['required'],
            'tipo_documento'=>'required',
            'num_documento'=>['required',Rule::unique('user_profiles','num_documento')->ignore($this->user->profile)],
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

    public function updateUser(User $user)
    {
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'state'=>$this->state
        ]);

        if ($this->password != null) {
            $user->password = bcrypt($this->password);
        }

        $user->save();

        $user->profile->update([
            'ubicacion'=>$this->ubicacion,
            'num_cel'=>$this->num_cel,
            'tipo_documento'=>$this->tipo_documento,
            'num_documento'=>$this->num_documento,
            'sucursal_id'=>$this->sucursal_id,
        ]);
        $user->seguridad()->update([
            'pregunta_1'=>$this->input('pregunta_1'),
            'pregunta_2'=>$this->input('pregunta_2'),
            'respuesta_1'=>$this->input('respuesta_1'),
            'respuesta_2'=>$this->input('respuesta_2'),
        ]);

    }
}
