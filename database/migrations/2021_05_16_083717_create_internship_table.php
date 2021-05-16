<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id')->unsigned();
            $table->foreign('employer_id')->references('id')->on('employer')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->string('requirement');
            $table->string('video')->nullable();
            $table->string('video_description')->nullable();
            $table->string('task')->nullable();
            $table->string('document')->nullable();
            $table->string('resource_link')->nullable();
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
        Schema::dropIfExists('internship');
    }
}
