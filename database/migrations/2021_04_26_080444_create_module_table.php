<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('section')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('module');
            $table->string('module_id');
            $table->string('assessment')->nullable();
            $table->string('assessment_id')->nullable();
            $table->string('document')->nullable();
            $table->string('document_id')->nullable();
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
        Schema::dropIfExists('module');
    }
}
