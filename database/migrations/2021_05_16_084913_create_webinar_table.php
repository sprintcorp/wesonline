<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id')->unsigned();
            $table->foreign('employer_id')->references('id')->on('employer')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->date('date');
            $table->time('time');
            $table->string('host')->nullable();
            $table->string('industry')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('webinar');
    }
}
