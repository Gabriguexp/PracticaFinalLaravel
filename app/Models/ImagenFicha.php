<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenFicha extends Model {
    use HasFactory;
    
    protected $table = "fichaimagen";

    protected $fillable = ['idficha', 'nombre', 'nombreoriginal', 'nuevonombre', 'mimetype', ];
    
    public function ficha(){
        return $this->belongsTo('\App\Models\Ficha', 'idficha');
    }
}
