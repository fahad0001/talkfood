<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\oauth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\OrderInfo;
use App\Item;

class api extends Controller
{
    //
     //Function For Api
    public function OrderFetch(Request $request) {
		// resturant id will be passed
       if(!isset($_SERVER['HTTP_AUTHTOKEN'])) {
           Return array("error"=>"error");
       }
       else if(!oauth::where('token', '=',$_SERVER['HTTP_AUTHTOKEN'])->exists()) {
            Return array("error"=>"error");
       }
       else {
           
           
           $rest=oauth::where('token','=',$_SERVER['HTTP_AUTHTOKEN'])->first();
           
        $response=array();
        
        //order detail with Customer Info
        
        $orderdetail = OrderInfo::with('customer')->where('rest_id', $rest->rest_id)->where('order_print_status','!=',1)->get();
        
        
        for ($x = 0; $x < $orderdetail->count(); $x++) {
            //order Item Detail with sub items
            $c=unserialize($orderdetail[$x]->cart);
            unset($c["totalquantity"]);
            $orderItemDetail[] = $c;
            //Customer Address
            if($orderdetail[$x]->addresstype=="ship")
            $CustomerAddress[] = \App\CustomerAddress::where('cus_id', $orderdetail[$x]->cust_id)->where('address_type', 'ship')->get();
            else
            $CustomerAddress[] = \App\CustomerAddress::where('cus_id', $orderdetail[$x]->cust_id)->where('address_type', 'del')->get();
            $r=  \App\Restaurant::where('rest_id',$rest->rest_id)->first();
       
            array_push($response,array("orderdetail"=> $orderdetail[$x],"customeraddress"=>$CustomerAddress[$x],"vendoraddress"=>$r,"orderitemdetail"=>$orderItemDetail[$x]));
        }
        
       
        return $response;
       }
        
    }
    
    public function login(Request $request) {
        
        
     $data = json_decode($request->getContent(), true);

         
    
       if(Auth::attempt(['email' => $data ['username'], 'password' => $data['password'], 'role' => 'rest'])) 
        {
         
           $d=new oauth;
          $r= \App\Restaurant::where('rest_user_id',Auth::user()->id)->first();
           $d->rest_id=$r->rest_id ;
           $d->token=$this->generatecode();
           $d->save();
           return $d->token;
       }
       else {
           return "fail";
       }
    }
    
     public function addprint($id){
        
        $update=OrderInfo::where('order_id',$id)->first();
        $update->order_print_status=1;
        $update->save();
        
        return "1";
        
        
    }
    
    public function generatecode() {
    $number = Hash::make(mt_rand(1000000000, 9999999999)); // better than rand()

    // call the same function if the barcode exists already
    if ($this->codeExists($number)) {
        return generatecode();
    }

    // otherwise, it's valid and can be used
    return $number;
}

public function codeExists($number) {
   
    
    $oauth = oauth::where('token',$number)->first();
     if ($oauth === null) {
   // user doesn't exist
         return false;
    }
    return true;
   
}


public function getlastprint() {
        
        if(!printing_order::first()) {
            
            return 0;
        }
        else {
            $lastprint = printing_order::orderBy('entity_id', 'desc')->first();
            
            return $lastprint;
        }
        
    }
    
    public function dispatch($id) {
        
         $update=OrderInfo::where('order_id',$id)->first();
        $update->order_status="complete";
        $update->save();
        
    }
    
}
