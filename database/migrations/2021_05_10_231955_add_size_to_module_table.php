<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeToModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('module', function (Blueprint $table) {
            $table->string('size')->nullable();
            $table->string('file_type')->nullable();
            $table->string('extension')->nullable();
            $table->string('original_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module', function (Blueprint $table) {
            //
        });
    }
}
