<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\restdashboard;
use App\Restaurant;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class newdashboard extends Controller
{
      // Update Availibility Status of All Resturants
    public function updateAvailibility($status)
    {
         $rests=Restaurant::paginate(15);
        Restaurant::query()->update(['rest_avail' => $status]);
        return view('admin.index',compact('rests'));
    }
public function autocomplete()
    {
        // $term = Input::get('term');
        // $term="the";
	
	$results = array();
	$rests = Restaurant::all();
	foreach ($rests as $query)
	{
	    $results[] = [ 'name' => $query->rest_name, 'code' => $query->rest_name ];
	}
return Response::json($results);
    }

    // public function autocomplete()
    // {
    //     // Input::get('q','')
	// 	$query = "the";

	// 	if(!$query && $query == '') return Response::json(array(), 400);

	// 	$rest = Restaurant::where('rest_name','like','%'.$query.'%')->get();
        

	// 	return Response::json(array(
	// 		'data'=>$rest
	// 	));
	// }
    
}
