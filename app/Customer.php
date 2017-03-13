<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'cust_id','cust_company','cust_street', 'cust_stpr', 'cust_city','cust_country','cust_phone','cust_pic_path'
    ];
    //
    protected $table = 'customer_table';
}
