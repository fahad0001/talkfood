<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    public $primaryKey  = 'order_id';
    protected $fillable = [
        'rest_id','cust_id','order_qty','order_total_amount','order_date','order_status','order_total_amount_tax','order_ship_price','order_ship_price','order_ship_tax','order_grand_total','order_print_status','addresstype','cart','paymentid'
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
