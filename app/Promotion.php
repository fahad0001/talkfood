<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
     protected $fillable = [
        'code', 'promotion_setting_id', 'user_id', 'used'
    ];
     
    protected $table='promotions';
}
