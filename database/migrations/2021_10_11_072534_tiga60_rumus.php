<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tiga60Rumus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiga60_rumus', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('periode')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('user_target_id_1')->nullable();
            $table->integer('user_target_id_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tiga60_rumus');
    }
}
