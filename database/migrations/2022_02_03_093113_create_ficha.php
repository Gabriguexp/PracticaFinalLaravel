<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficha', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->string('imagen');
            $table->integer('coste');
            $table->integer('ad');
            $table->integer('ap');
            $table->integer('vida');
            $table->integer('mana');
            $table->text('ulti');
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
        Schema::dropIfExists('ficha');
    }
}
