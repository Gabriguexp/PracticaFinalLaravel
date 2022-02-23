<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Atributoficha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atributoficha', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idficha')->unsigned();
            $table->bigInteger('idatributo')->unsigned();
            $table->foreign('idficha')->references('id')->on('ficha');
            $table->foreign('idatributo')->references('id')->on('atributo');            
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
        //
    }
}
