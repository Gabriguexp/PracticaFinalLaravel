<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    function attributes(){
        return [
            'name' => 'Nick',
            'email' => 'Coste',
            'password' => 'Contraseña',
            'password_confirmation' => 'Confirmar contraseña',
            'rol' => 'Rol',
            'validated' => 'Validado',
        ];
    }
 
    public function authorize(){
        if (auth()->user() != null && (auth()->user()->rol == 'admin' || auth()->user()->rol == 'root')){
            return true; 
        }
        return false;
    }
    
    public function messages(){
        return [
            'name.required' => 'El :attribute es requerido',
            'name.unique' => 'El :attribute debe ser único',
            'email.required' => 'El :attribute es requerido',
            'email.email' => 'El :attribute debe ser un email',
            'email.unique' => 'El :attribute debe ser único',
            'password.confirmed' => 'Las contraseñas deben coincidir',
            'rol.required' => 'El :attribute es requerido',
            'rol.in' => 'El :attribute debe tener un valor valido',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:users,name,'.$this->user['id'],
            'email' => 'required|email|unique:users,email,'.$this->user['id'],
            // 'password' => 'confirmed|min:8',
            'password_confirmation' => '',
            'rol' => 'required|in:user,admin,root',
            
        ];
    }
}
