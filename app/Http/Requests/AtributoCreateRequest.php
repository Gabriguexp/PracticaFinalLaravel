<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtributoCreateRequest extends FormRequest
{
    function attributes(){
        return [
            'nombre' => 'Nombre',
            'descripcion' => 'Coste',
            'tipo' => 'Tipo',
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
            'nombre.required' => 'El campo :attribute es requerido',
            'nombre.max' => 'El campo :attribute debe tener como máximo :value caracteres',
            'nombre.unique' => 'El :attribute debe ser único',
            'descripcion.required' => 'El campo :attribute es requerido',
            'descripcion.max' => 'El campo :attribute debe tener como máximo :value caracteres',
            'tipo.required' => 'El campo :attribute es requerido',
            'tipo.in' => 'El campo :attribute debe tener como valor :value'
            
            
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
            
            'nombre' => 'required|max:50|unique:atributo,nombre',
            'descripcion' => 'required|max:200',
            'tipo' => 'required|in:clase,origen',
        ];
    }
}
