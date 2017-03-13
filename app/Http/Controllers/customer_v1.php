<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Item;
use App\Category;
use App\Food;
use Illuminate\Support\Facades\Response;
use App\OrderInfo;
use Carbon\Carbon;
use App\User;
use App\CustomerAddress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\restdashboard;
use App\Shipping;


class customer extends Controller {

    public function index() {


        if (!Session::has('cart')) {

            return Response::view('customer.index')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {

            $cart = Session::get('cart');
            return Response::view('customer.index', compact('cart'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }

    public function search($lat, $lng) {


        $radius = 15;
        $rest = new Restaurant;
        $data = $this->haversine($rest, $lat, $lng, 15);

        if (!Session::has('cart')) {

            return Response::view('customer.result', compact('data'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {
            $cart = Session::get('cart');
            return Response::view('customer.result', compact('data', 'cart'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }

    public function menu($id) {


        $restinfo=  Restaurant::where('rest_id',$id)->first();
        $data = DB::table('food_table')
                ->join('category_table', 'food_table.cate_id', '=', 'category_table.cate_id')
                ->select('food_table.*', 'category_table.*')
                ->orderBy('category_table.cate_name', 'Asc')
                ->get();
        $cats = Category::where('rest_id', '=', $id)->get();

        if (!Session::has('cart')) {

            return Response::view('customer.menu', compact('data', 'cats','restinfo'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {

            $cart = Session::get('cart');
            return Response::view('customer.menu', compact('data', 'cats', 'cart','restinfo'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }
public function viewsubmenu($id) {

        
        $submenu=  \App\SubMenu::where('food_id',$id)->get();
        
    return view('customer.submenu',  compact('submenu'));
    }
    public function addtocart($id) {

        if (!Session::get('cart')) {

            $item = Food::where('food_id', '=', $id)->first()->toArray();
            $item['quantity'] = 1;
            $cart = array(0 => $item,'totalquantity'=>1);
            
            
            Session::put('cart', $cart);
            return "ok";
        } else {

            $item = Food::where('food_id', '=', $id)->first()->toArray();

            $cart = Session::get('cart');
           
            Session::forget('cart');

            $key = array_search($id, array_column($cart, 'food_id'));

            if ($key !== false) {
                $cart[$key]['quantity'] ++;
                $cart['totalquantity']++;
                Session::put('cart', $cart);
                return "key contains ,quantity incremented";
            } else {
                $item = Food::where('food_id', '=', $id)->first()->toArray();
                $item['quantity'] = 1;
                
                array_push($cart, $item);
                $cart['totalquantity']++;
                Session::put('cart', $cart);
                return "new item added";
            }
        }
    }
    
      public function addtocartsub($id) {

        if (!Session::get('cart')) {
            $subitem=  \App\SubMenu::find($id);
            $item = Food::where('food_id', '=', $subitem->food_id)->first()->toArray();
            $item['quantity'] = 1;
            $item['subitem']= $subitem->toArray();
            $cart = array(0 => $item,'totalquantity'=>1);
            
            
            Session::put('cart', $cart);
            return $cart;
        } else {
             $subitem=  \App\SubMenu::find($id);
           $item = Food::where('food_id', '=', $subitem->food_id)->first()->toArray();

            $cart = Session::get('cart');
           
            Session::forget('cart');

            $key = array_search($subitem->food_id, array_column($cart, 'food_id'));
            

            if ($key !== false) {
                if( $cart[$key]['subitem']['id']==$id) {
                
                $cart[$key]['quantity'] ++;
                $cart['totalquantity']++;
                Session::put('cart', $cart);
                return $cart;
                    
                }
                
               
            else {
                 $subitem=  \App\SubMenu::find($id);
                $item = Food::where('food_id', '=', $subitem->food_id)->first()->toArray();
                $item['quantity'] = 1;
                 $item['subitem']= $subitem->toArray();
                array_push($cart, $item);
                $cart['totalquantity']++;
                Session::put('cart', $cart);
                return $cart;
            }
        }
        }
    }

    public function cart() {

         if (!Session::has('cart')) {

            return Response::view('customer.cart')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {
            
            

            $cart = Session::get('cart');
            $subtotal=0;
            
            foreach($cart as $c ) {
                if($c['submenu_status']==1) {
                     $subtotal=$subtotal+((floatval($c['food_price'])+floatval($c['subitem']['price']))*floatval($c['quantity']));
                }
                else {
                    $subtotal=$subtotal+(floatval($c['food_price'])*floatval($c['quantity']));
                }
                
            }
            $s= Shipping::first();
            $tax= (floatval($s->tax)/100)*$subtotal;
            $shipping=floatval($s->ship_price);
            $shippingtax=(floatval($s->ship_tax)/100) *$shipping;
             $shipping= $shipping+$shippingtax;
            $total=$subtotal+$tax+$shipping;
            return Response::view('customer.cart', compact('cart','subtotal','total','shipping','tax'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }
    
    
    public function updatecart() {

           $cart = Session::get('cart');
           
            Session::forget('cart');
            
            foreach(Input::get('items') as $key=>$value) {
                 $key = array_search($key, array_column($cart, 'food_id'));
                if ($key !== false) {
                 $cart[$key]['quantity']=$value;
                }
                 
            }
            
            $totalquantity =0;
            foreach($cart as $c) {
                $totalquantity=$totalquantity+$c['quantity'];
                
            }
            $cart['totalquantity']=$totalquantity;
            Session::put('cart',$cart);
            

        return redirect('/cart');
           
        
       
    }
    public function deletefromcart($id) {
        
        
           $cart = Session::get('cart');
           
            Session::forget('cart');
            
            if(count($cart)==2) {
                 Session::forget('cart');
            
                 return redirect('/cart');
            }
            else {
            foreach($cart as $key=>$value) {
                 $key = array_search($id, array_column($cart, 'food_id'));
                if ($key !== false) {
                    unset($cart[$key]);
                
                }
                 
            }
            
            $totalquantity =0;
            foreach($cart as $c) {
                $totalquantity=$totalquantity+$c['quantity'];
                
            }
            $cart['totalquantity']=$totalquantity;
            Session::put('cart',$cart);
            

        return redirect('/cart');
            }
           
        
    }
    
    
    public function checkout() {
        
        if(Auth::check()) {
            $cart=Session::get('cart');
            $restid=0;
            foreach($cart as $c) {
                if(is_array($c)) {
                       $restid= $c['rest_id'];
                }
            
        }
           $o=new OrderInfo;
           $o->cust_id=Auth::user()->id;
           $o->rest_id=$restid;
           $o->order_qty=$cart["totalquantity"];
           $o->created_at=Carbon::now();
           $o->order_status="pending";
           $o->save();
           $total=0;
            foreach($cart as $a) {
                if(is_array($a)) {
                 $i=new Item;
                 $i->itemid=$a['food_id'];
                 $i->order_id=$o->order_id;
                 $i->item_name=$a['food_name'];
                  $i->item_price=$a['food_price'];
                  $i->item_qty=$a['quantity'];
                  
                  if($a['submenu_status']=="1"){
                       $i->subitem_id=$a['subitem']['id'];
                      
                       $total=$total+(floatval(($i->item_price)+floatval($a['subitem']['price']))* floatval($i->item_qty));
                       $i->save();
                       
                  }
                  else {
                      $total=$total+(floatval($i->item_price)* floatval($i->item_qty));
                       $i->save();
                  }
                 
                  
                }
                  
               
        }
        $o->order_total_amount=$total;
            $o->save();
           Session::forget('cart');
      return redirect('customer/orders')->with('message','You order is placed!');
            
        }
        
        else {
            
            return redirect('/signup?returnurl=checkout');
        }
        
    }
    
    public function orders() {
        
        $orders = OrderInfo::where('cust_id',Auth::user()->id)->orderBy('order_id','desc')->get();
        return view('customer.orders',compact('orders'));
        
        
    }
    
    public function orderdetails($id) {
        
       $data= restdashboard::orderdetailData($id);
       $orderinfo=$data[0];
       $customeraddress=  CustomerAddress::where('cus_id',$orderinfo['customer']->id)->get();
       $orderinfo['customerAddress']=$customeraddress[0];
       $items=$data[1];
       $subtotal=$orderinfo->order_total_amount;
        // $s= Shipping::first();
        //    $tax= ($s->tax/100)*$subtotal;
         //   $shipping=$s->ship_price;
         //   $shippingtax=($s->ship_tax/100) *$shipping;
           //  $shipping= $shipping+$shippingtax;
           // $total=$subtotal+$tax+$shipping;
            
              $s= Shipping::first();
            $tax= (floatval($s->tax)/100)*$subtotal;
            $shipping=floatval($s->ship_price);
            $shippingtax=(floatval($s->ship_tax)/100) *$shipping;
             $shipping= $shipping+$shippingtax;
            $total=$subtotal+$tax+$shipping;
            
            
      // return var_dump($items->toArray());
       return view('customer.orderdetails',compact('orderinfo','items','total'));
    }
    
    public function account() {
        
        $user=User::where('id',Auth::user()->id)->get();
       $cus= CustomerAddress::where('cus_id',Auth::user()->id)->get();
        return view('customer.account',compact('user','cus'));
    }
    
    
    public function accountupdate() {
        
         $rules = array(
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'cust_ship_street' => 'required|max:255',
                'cust_ship_city' => 'required|max:255',
                'cust_ship_state' => 'required|max:255',
                'cust_ship_country' => 'required|max:255',
                'cust_ship_zip' => 'required|max:255',
                'cust_ship_phone' => 'required|max:255',
                'cust_bill_street' => 'required|max:255',
                'cust_bill_city' => 'required|max:255',
                'cust_bill_state' => 'required|max:255',
                'cust_bill_country' => 'required|max:255',
                'cust_bill_zip' => 'required|max:255',
                'cust_bill_phone' => 'required|max:255',
                'email' => 'required|email|max:255'
               
               
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->passes()) {
                    
             //  return var_dump(Input::all());
                $firstName = Input::get('firstname');
                $lastName = Input::get('lastname');

                $cusShipStreet = Input::get('cust_ship_street');
                $cusShipCity = Input::get('cust_ship_city');
                $cusShipState = Input::get('cust_ship_state');
                $cusShipCountry = Input::get('cust_ship_country');
                $cusShipZipCode = Input::get('cust_ship_zip');
                $cusShipPhoneNo = Input::get('cust_ship_phone');

                $cusBillStreet = Input::get('cust_bill_street');
                $cusBillCity = Input::get('cust_bill_city');
                $cusBillState = Input::get('cust_bill_state');
                $cusBillCountry = Input::get('cust_bill_country');
                $cusBillZipCode = Input::get('cust_bill_zip');
                $cusBillPhoneNo = Input::get('cust_bill_phone');

                $emailNo = Input::get('email');
               

                $user = User::where('id',Auth::user()->id)->update([
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                           
                            'email' => $emailNo
                           
                             
                ]);
                
               
                $ship_adress = CustomerAddress::where('cus_id',Auth::user()->id)->where('address_type','ship')->update([
                            'street' => $cusShipStreet,
                            'city' => $cusShipCity,
                            'country' => $cusShipCountry,
                            'zip_code' => $cusShipZipCode,
                            'state_province' => $cusShipState,
                            'phone_no' => $cusShipPhoneNo,
                            'cus_id' => Auth::user()->id,
                            'address_type' => 'ship',
                ]);
                $bill_adress = CustomerAddress::where('cus_id',Auth::user()->id)->where('address_type','bill')->update([
                            'street' => $cusBillStreet,
                            'city' => $cusBillCity,
                            'country' => $cusBillCountry,
                            'zip_code' => $cusBillZipCode,
                            'state_province' => $cusBillState,
                            'phone_no' => $cusBillPhoneNo,
                            'cus_id' =>  Auth::user()->id,
                            'address_type' => 'bill',
                ]);
                return Redirect::to('customer/account')->with('message','Account information updated.');
            }
            else {
                return Redirect::to('customer/account')->with('emessage', 'The following errors occurred')->withErrors($validator);
          
            }
    }

    public static function haversine($query, $lat, $lng, $max_distance = 25, $units = 'kilometers', $fields = false) {

        if (empty($lat)) {
            $lat = 0;
        }
        if (empty($lng)) {
            $lng = 0;
        }
        /*
         *  Allow for changing of units of measurement
         */
        switch ($units) {
            case 'miles':
//radius of the great circle in miles
                $gr_circle_radius = 3959;
                break;
            case 'kilometers':
//radius of the great circle in kilometers
                $gr_circle_radius = 6371;
                break;
        }
        /*
         *  Support the selection of certain fields
         */
        if (!$fields) {
            $fields = 'restaurant_table.*';
        }
        /*
         *  Generate the select field for disctance
         */
        $distance_select = sprintf(
                "           
					                ROUND(( %d * acos( cos( radians(%s) ) " .
                " * cos( radians( rest_lat ) ) " .
                " * cos( radians( rest_long ) - radians(%s) ) " .
                " + sin( radians(%s) ) * sin( radians( rest_lat ) ) " .
                " ) " .
                ")
        							, 2 ) " .
                "AS distance
					                ", $gr_circle_radius, $lat, $lng, $lat
        );

        $data = $query->select(DB::raw($fields . ',' . $distance_select))
                ->having('distance', '<=', $max_distance)
                ->orderBy('distance', 'ASC')
                ->where('restaurant_table.rest_status','active')
                ->get();

//echo '<pre>';
//echo $query->toSQL();
//echo $distance_select;
//echo '</pre>';	
//die();	
//
//$queries = DB::getQueryLog();
//$last_query = end($queries);
//var_dump($last_query);
//die();
        return $data;
    }

}
