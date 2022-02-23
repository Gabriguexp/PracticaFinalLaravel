<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FichaEditRequest extends FormRequest
{
    function attributes(){
        return [
            'nombre' => 'Nombre',
            'coste' => 'Coste',
            'ad' => 'Daño de ataque',
            'ap' => 'Poder de habilidad',
            'vida' => 'Vida',
            'mana' => 'Mana',
            'ulti' => 'Definitiva',
            'imagen' => 'Imagen',
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
            'nombre.required' => 'El :attribute es requerido',
            'nombre.max' => 'El :attribute no puede contener más de :value carácteres',
            'nombre.unique' => 'El :attribute debe ser único',
            'coste.required' => 'El :attribute es requerido',
            'coste.lte' => 'El :attribute debe ser menor o igual a :value',
            'coste.gte' => 'El :attribute debe ser mayor o igual a :value',
            'coste.numeric' => 'El :attribute debe numérico',
            'ad.required' => 'El :attribute es requerido',
            'ad.gte' => 'El :attribute debe ser mayor o igual a :value',
            'ad.numeric' => 'El :attribute debe numérico',
            'ap.required' => 'El :attribute es requerido',
            'ap.gte' => 'El :attribute debe ser mayor o igual a :value',
            'ap.numeric' => 'El :attribute debe numérico',
            'vida.required' => 'El :attribute es requerido',
            'vida.gte' => 'El :attribute debe ser mayor o igual a :value',
            'vida.numeric' => 'El :attribute debe numérico',
            'mana.required' => 'El :attribute es requerido',
            'mana.gte' => 'El :attribute debe ser mayor o igual a :value',
            'mana.numeric' => 'El :attribute debe numérico',
            'ulti.required' => 'El :attribute es requerido',
            'imagen.required' => 'El :attribute es requerido',
            'imagen.image' => 'El :attribute debe ser una imagen',
            
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
            'nombre' => 'required|max:50|unique:ficha,nombre,'.$this->ficha['id'],
            'coste' => 'required|lte:5|gte:1',
            'ad' => 'required|gte:1|numeric',
            'ap' => 'required|gte:1|numeric',
            'vida' => 'required|gte:1|numeric',
            'mana' => 'required|gte:1|numeric',
            'ulti' => 'required',
            'imagen' => 'image',
        ];
    }
}
