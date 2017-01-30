<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batsmenrecords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('player');
            $table->float('Gavg');
            $table->float('Gsr');
            $table->float('LTavg');
            $table->float('LTsr');
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
        Schema::dropIfExists('records');
    }
}
