<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionIdToUserPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_permission', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permission')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_permission', function (Blueprint $table) {
            //
        });
    }
}
