<?php

namespace App;

class Location extends Elegant
{
    protected $table = 'locations';
    protected $fillable = ['town','name'];
    public static $rules = [
        'town'=> 'required|string',
        'name'=> 'required|string'
    ];
}
