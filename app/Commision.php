<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commision extends Model
{
    protected $fillable = [
        'commis_type', 'commis_percent'
    ];
    //
    protected $table = 'commis_table';
}
