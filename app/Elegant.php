<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class Elegant extends Model
{
    public static $rules = array();
    protected $errors;
    public function validate($data, $rules){
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            $this->errors = $validator->messages();
            return false;
        }
        return true;
    }
    public function errors(){
        return $this->errors;
    }
}