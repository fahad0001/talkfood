<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'itemid', 'order_id','item_name','item_price','item_qty','subitem_id'
    ];
    //
    protected $table = 'item_table';
    public $timestamps=false;
    
     public function subItem(){
        return $this->hasOne('App\SubMenu', 'id','subitem_id');
    }
}
