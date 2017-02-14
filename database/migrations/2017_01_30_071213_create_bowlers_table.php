<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBowlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bowlers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('match_id');
            $table->string('name');
            $table->integer('run');
            $table->float('over');
            $table->integer('maiden');
            $table->integer('wicket');
            $table->float('economy');
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
        Schema::dropIfExists('bowlers');
    }
}
