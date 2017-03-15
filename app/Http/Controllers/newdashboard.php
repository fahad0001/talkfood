<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\restdashboard;
use App\Restaurant;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class newdashboard extends Controller
{
      // Update Availibility Status of All Resturants
    public function updateAvailibility($status)
    {
         $rests=Restaurant::paginate(15);
        Restaurant::query()->update(['rest_avail' => $status]);
        return view('admin.index',compact('rests'));
    }
    
}
