<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('users');
            $table->integer('car_id')->unsigned();
            $table->foreign('car_id')->references('id')->on('cars');
            $table->integer('accountant_id')->unsigned()->nullable();
            $table->foreign('accountant_id')->references('id')->on('users');
            $table->date('travel_date');
            $table->decimal('total_distance', 6, 2);
            $table->text('reason');
            $table->text('observations');
            $table->decimal('estimate_cost', 6, 2);
            $table->integer('status')->default(0);
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
        Schema::drop('travels');
    }
}
