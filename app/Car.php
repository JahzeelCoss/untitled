<?php

namespace App;

class Car extends Elegant
{
    protected $table = 'cars';
    protected $fillable = ['brand','description','plates','km_liter'];
    public static $rules = [
        'brand'=> 'required|string',
        'description' => 'required|string',
        'plates'=>'required|string',
        'km_liter'=>'required|numeric'
    ];
}
