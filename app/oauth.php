<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oauth extends Model
{
    //
    
     protected $fillable = [
        'id','rest_id','token'
    ];
    public $timestamps=false;
    
     protected $table = 'oauth';
}
