<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\restdashboard;
use App\Restaurant;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use App\User;


class newdashboard extends Controller
{
      // Update Availibility Status of All Resturants
    public function updateAvailibility($status)
    {
        $rests=Restaurant::paginate(15);
        Restaurant::query()->update(['rest_avail' => $status]);
        return view('admin.index',compact('rests'));
    }
    
    public function searchCustomer()
    {
        $rests=User::where('role','cus')->get();
        return view('admin.search',compact('rests'));
    }
    public function doSearchCustomerModule()
    {
        $type=Input::get('search');
        $value=Input::get('name');
        if($type=="fname"){    
                $rests=User::where('role','cus')
                        ->Where('first_name','LIKE',"%".$value."%")
                        ->get();
            return view('admin.search',compact('rests'));
        }
        else if($type=="lname"){    
                $rests=User::where('role','cus')
                        ->Where('last_name','LIKE',"%".$value."%")
                        ->get();
            return view('admin.search',compact('rests'));
        }
        else if($type=="email"){
             $rests=User::where('role','cus')
                        ->where('email','LIKE',"%".$value."%")
                        ->get();
            return view('admin.search',compact('rests'));
        }       
    }

    public function doSearchRestuarant(){
        $search=Input::get('search');
        if($search!=null){
             $rests=Restaurant::where('rest_name','LIKE',"%".$search."%")
                                ->paginate(15);            
            return view('admin.index',compact('rests'));
        }
    }

        public function doSearchCustomer(){
        $value=Input::get('search');
        $type=Input::get('type');
        if($type=="fname"){    
                $rests=User::where('role','cus')
                        ->Where('first_name','LIKE',"%".$value."%")
                        ->paginate(15);
            return view('admin.viewcustomer',compact('rests'));
        }
        else if($type=="lname"){    
                $rests=User::where('role','cus')
                        ->Where('last_name','LIKE',"%".$value."%")
                        ->paginate(15);
            return view('admin.viewcustomer',compact('rests'));
        }
        else if($type=="email"){
             $rests=User::where('role','cus')
                        ->where('email','LIKE',"%".$value."%")
                        ->paginate(15);
            return view('admin.viewcustomer',compact('rests'));
        }       
    }
    public function doSearchOrderInfo(){
        $value=Input::get('search');
        $orderdetail=OrderInfo::where('order_id',$value)->with('customer')->orderBy('order_id','Desc')->paginate(15);
        return view('admin.allorders', compact('orderdetail'));
    }



    
}
