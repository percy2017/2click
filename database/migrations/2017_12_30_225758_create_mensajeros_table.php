<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajeros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias');
            $table->string('imagen_permiso')->nullable();
            $table->string('imagen_placa')->nullable();
            $table->string('imagen_inspeccion')->nullable();
            $table->string('imagen_soat')->nullable();
            $table->boolean('habilitado')->default(1);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('vehiculo_id')->unsigned();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
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
        Schema::dropIfExists('mensajeros');
    }
}
