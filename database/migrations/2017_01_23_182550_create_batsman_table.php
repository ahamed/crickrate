<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatsmanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batsmen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('match_id');
            $table->string('cap');
            $table->string('name');
            $table->integer('run');
            $table->integer('ball');
            $table->float('sr');
            $table->integer('fours');
            $table->integer('sixs');
            $table->boolean('isActive');
            $table->boolean('onStrike');
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
        Schema::dropIfExists('batsmans');
    }
}
