<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\restdashboard;
use App\Restaurant;
use App\Http\Requests;
use App\Category;
use App\OrderInfo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class newdashboard extends Controller
{
    // update status of order
    public function updateStatus(Request $request)
    {
        $orderDetails=OrderInfo::where('order_id',$request['orderId'])->first();
        $orderDetails->order_status=$request['status'];
        $orderDetails->save();
        return $orderDetails->order_status;
    }

      // Update Availibility Status of All Resturants
    public function updateAvailibility($status)
    {
         $rests=Restaurant::paginate(15);
        Restaurant::query()->update(['rest_avail' => $status]);
        return view('admin.index',compact('rests'));
    }

    //Category Submenu
    public function viewCategory() {
        $user = Input::get('search');
        $catDetail=null;
        if($user!="")
        {
        $userData = Restaurant::where('rest_name', $user)->first();
        $catDetail = Category::where('rest_id', $userData->rest_id)->paginate(15);
        $restId=$userData->rest_id;
        }
        return view('admin.food.category', compact('catDetail','restId'));
    }

    public function createCategory($id) {
        $category = new Category();
        $category->cate_name = Input::get('CategoryType');
        $category->rest_id = $id; //rest_id which is auto increment will be used
        $category->save();
        $catDetail = Category::where('rest_id', $id)->paginate(15);
        $restId=$id;
        return view('admin.food.category', compact('catDetail','restId'))->with('success', 'Successfully added');
    }

    public function deleteCategory($id) {
        $cateDetail = Category::where('cate_id', $id)->first();
        $restId=$cateDetail->rest_id;
        Category::where('cate_id', $id)->delete();
        $catDetail = Category::where('rest_id', $restId)->paginate(15);
        return view('admin.food.category', compact('catDetail','restId'))->with('success', 'Successfully deleted');
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
    }
