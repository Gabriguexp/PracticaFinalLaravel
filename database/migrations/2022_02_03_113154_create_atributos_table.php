<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtributosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atributo', function (Blueprint $table) {
            $table->id();
            //Atributos( id, nombre, habilidad que aporta.) 
            $table->string('nombre');
            $table->text('descripcion');
            $table->enum('tipo', ['clase', 'origen']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atributos');
    }
}
