<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $fillable = [
        'id','name','desc','price','food_id','option','type'
    ];
    public $timestamps=false;
    //
    protected $table = 'menu_option';
  
}
