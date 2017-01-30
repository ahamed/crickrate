<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBowlerRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bowlerrecords', function (Blueprint $table) {
             $table->increments('id');
            $table->string('player');
            $table->float('Gavg');
            $table->float('Gecono');
            $table->float('LTavg');
            $table->float('LTecono');
            $table->float('value');
            $table->string('country');
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
