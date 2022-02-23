<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Atributo;

class Ficha extends Model
{
    use HasFactory;
    
    //Fichas (id, nombre, imagen, coste, ad, ap, vida, mana, habilidad_definitiva)
    
    protected $table = "ficha";
    protected $fillable = ['nombre', 'imagen', 'coste', 'ad', 'ap', 'vida', 'mana', 'ulti'];
    
    public function atributos(){
        return $this->belongsToMany(Atributo::class, 'atributoficha', 'idficha', 'idatributo');
    }
    
    public function imagen(){
        return $this->hasMany('\App\Models\Imagen', 'id');
    }
    
}
