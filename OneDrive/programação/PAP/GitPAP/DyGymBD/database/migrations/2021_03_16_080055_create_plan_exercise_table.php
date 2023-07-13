<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_exercise', function (Blueprint $table) {
            $table->id();
            $table->string('Sets');
            $table->string('Reps');
            $table->unsignedBigInteger('id_plans');
            $table->foreign('id_plans')->references('id')->on('plans');
            $table->unsignedBigInteger('id_exer');
            $table->foreign('id_exer')->references('id')->on('exercises');
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
        Schema::dropIfExists('plan_exercise');
    }
}