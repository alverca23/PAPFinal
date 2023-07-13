<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacions', function (Blueprint $table) {
            $table->id();
            $table->integer('IMC');
            $table->integer('Agachamento');
            $table->integer('Supino');
            $table->integer('Levantamento_Terra');
            $table->string('Data');
            $table->string('Weight');
            $table->string('Height');
            $table->string('Peso_meta');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('avaliacions');
    }
}