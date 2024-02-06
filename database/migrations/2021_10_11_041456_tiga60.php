<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tiga60 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiga60', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('periode')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('user_target_id')->nullable();
            $table->string('komponen')->nullable();
            $table->integer('point')->nullable();
            $table->integer('nilai')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tiga60');
    }
}
