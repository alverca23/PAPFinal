<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration
{
    /**
     * 
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('birthday');
            $table->string('height');
            $table->string('weight');
            $table->string('hobbies');
            $table->integer('peso_meta');
            $table->integer('supino');
            $table->integer('agachamento');
            $table->integer('levantamento');
            $table->string('date');
            $table->unsignedBigInteger('id_pts')->nullable();
            $table->foreign('id_pts')->references('id')->on('pts');
            $table->unsignedBigInteger('id_conta')->nullable();
            $table->foreign('id_conta')->references('id')->on('admins');
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
        Schema::dropIfExists('users');
    }
}