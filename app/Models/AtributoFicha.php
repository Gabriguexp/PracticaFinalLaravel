<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AtributoFicha extends Model
{
    use HasFactory;
    protected $table = "atributoficha";
    protected $fillable= ['idficha', 'idatributo'];
    
    // public function fichas(){
    //     return $this->belongsToMany(Ficha::class)->using(RoleUser::class);
    // }
    // public function users(){
    //     return $this->belongsToMany(User::class)->using(RoleUser::class);
    // }
}
