<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public $primaryKey  = 'rest_id';
    protected $guarded = [];
    //
    protected $table = 'restaurant_table';

    // public function AvailibilityOff()
    // {
    //     App\Restaurant::update('rest_avail','Offline');
    // }
    // public function AvailibilityOn()
    // {
    //     App\Restaurant::update('rest_avail','Online');
    // }

}
