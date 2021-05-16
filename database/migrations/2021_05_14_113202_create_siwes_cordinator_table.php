<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiwesCordinatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siwes_cordinator', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('institution_id')->unsigned();
            $table->foreign('institution_id')->references('id')->on('institution')->onDelete('cascade');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('slug');
            $table->string('staff_id')->nullable();
            $table->string('state')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('siwes_cordinator');
    }
}
