<?php

namespace App;

class TravelDetail extends Elegant
{
    protected $table = 'travel_details';
//    protected $fillable = ['name'];


    public function route(){
        return $this->belongsTo('App\Route');
    }
//    public function driver(){
//        return $this->belongsTo('App\User', 'driver_id');
//    }

}