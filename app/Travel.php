<?php

namespace App;

class Travel extends Elegant
{
    protected $table = 'travels';
//    protected $fillable = ['name'];
    public static $rules = [
        'name'=> 'required|string|unique:locations'
    ];

    public function travelDetails(){
        return $this->hasMany('App\TravelDetail');
    }

    public function driver(){
        return $this->belongsTo('App\User', 'driver_id');
    }

    public function car(){
        return $this->belongsTo('App\Car', 'car_id');
    }

    public function accountant(){
        return $this->belongsTo('App\User', 'accountant_id');
    }

    public function getStatus(){
        switch($this->status){
            case 0:
                return 'No aprobado';
                break;
            case 1:
                return 'Pendiente';
                break;
            case 2:
                return 'Aprobado';
                break;
            deafult:
                return 'Pendiente';
                break;
        }
    }

}
