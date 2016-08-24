<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('origin_location_id')->unsigned();
            $table->foreign('origin_location_id')->references('id')->on('locations');
            $table->integer('destination_location_id')->unsigned();
            $table->foreign('destination_location_id')->references('id')->on('locations');
            $table->float('distance');
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
        Schema::drop('routes');
    }
}
