<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaImagen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichaimagen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idficha')->unsigned();
            $table->string('nombre');
            $table->string('nombreoriginal');
            $table->string('nuevonombre');
            $table->string('mimetype');
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
        Schema::dropIfExists('fichaimagen');
    }
}
