<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
     protected $fillable = [
        'ship_price','ship_tax','tax', 'driver_tip'
    ];
     
    protected $table='shipping_table';
}
