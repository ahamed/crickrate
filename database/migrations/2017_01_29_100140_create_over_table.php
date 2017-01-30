<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('match_id');
            $table->string('innings');
            $table->integer('overno');
            $table->string('thisover');
            $table->integer('runs');
            $table->integer('isOver');
            $table->boolean('overflag');
            $table->integer('overextra');
            $table->integer('bowlerextra');
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
        Schema::dropIfExists('overs');
    }
}
