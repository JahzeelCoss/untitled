<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('travel_id')->unsigned();
            $table->foreign('travel_id')->references('id')->on('travels');
            $table->integer('route_id')->unsigned();
            $table->foreign('route_id')->references('id')->on('routes');
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
        Schema::drop('travel_details');
    }
}
