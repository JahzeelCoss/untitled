<?php

namespace App;


class Gas extends Elegant
{
    protected $table = 'gas';
    protected $fillable = ['price'];
    public static $rules = [
        'price'=> 'required|numeric'
    ];
}
