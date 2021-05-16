<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiwesSupervisorStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siwes_supervisor_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('student')->onDelete('cascade');
            $table->unsignedBigInteger('siwes_supervisor_id')->unsigned();
            $table->foreign('siwes_supervisor_id')->references('id')->on('siwes_supervisor')->onDelete('cascade');
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
        Schema::dropIfExists('siwes_supervisor_student');
    }
}
