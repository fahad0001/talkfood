<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    public $primaryKey  = 'order_id';
    protected $fillable = [
        'rest_id', 'cust_id','order_qty','order_total_amount','order_date'
    ];
    //
    protected $table = 'order_info';
    
    public function customer(){
        return $this->hasOne('App\User', 'id','cust_id');
    }

    // public function OrderDetailModel()
    // {
    //     return $this->hasMany('App\Item','order_id','order_id');
    // }
    
}
