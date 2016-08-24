<?php

namespace App;

class Route extends Elegant
{
    protected $table = 'routes';
    protected $fillable = ['origin_location_id', 'destination_location_id', 'distance'];
    public static $rules = array(
        'origin_location_id'=> 'required|integer|exists:locations,id',
        'destination_location_id'=> 'required|integer|different:origin_location_id|exists:locations,id',
        'distance'=> 'required|numeric|'
    );

    public function origin_location()
    {
        return $this->belongsTo('App\Location', 'origin_location_id');
    }
    public function destination_location()
    {
        return $this->belongsTo('App\Location', 'destination_location_id');
    }
}
