<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public $primaryKey  = 'rest_id';
    protected $guarded = [];
    //
    protected $table = 'restaurant_table';
}
