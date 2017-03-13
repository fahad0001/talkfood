<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionSetting extends Model
{
     protected $fillable = [
        'name', 'status', 'usage', 'expiry'
    ];
     
    protected $table='promotion_settings';
}
