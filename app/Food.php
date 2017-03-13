<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public $primaryKey  = 'food_id';
    protected $fillable = [
        'food_name','food_desc','food_price', 'cate_id', 'food_pic_path','rest_id','submenu_status'
    ];
    //
    protected $table = 'food_table';

    public function foodCategory(){
        return $this->hasOne('App\Category', 'cate_id','cate_id');
}
}
