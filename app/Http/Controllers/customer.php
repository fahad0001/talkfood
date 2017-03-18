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
use Stripe\Stripe;
use Stripe\Charge;
use App\Promotion;
use App\PromotionSetting;
use GuzzleHttp;
use Storage;

class customer extends Controller {

    public function index() {

//Session::forget('cart');
        if (!Session::has('cart')) {

            return Response::view('customer.index')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {

            $cart = Session::get('cart');
            return Response::view('customer.index', compact('cart'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }

    public function search($lat, $lng) {

        //Session::forget('cart');
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


        $restinfo = Restaurant::where('rest_id', $id)->first();

        $data = DB::table('food_table')
                ->join('category_table', 'food_table.cate_id', '=', 'category_table.cate_id')
                ->select('food_table.*', 'category_table.*')
                ->orderBy('category_table.cate_name', 'Asc')
                ->get();
        $cats = Category::where('rest_id', '=', $id)->get();

        if (!Session::has('cart')) {

            return Response::view('customer.menu', compact('data', 'cats', 'restinfo'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {

            $cart = Session::get('cart');
            return Response::view('customer.menu', compact('data', 'cats', 'cart', 'restinfo'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }

    public function viewsubmenu($id) {


        $submenu = \App\SubMenu::where('food_id', $id)->get();
        $opt = DB::table('menu_option')
                ->select('type', 'option')
                ->where('food_id', $id)
                ->distinct()
                ->get();
        return view('customer.submenu', compact('submenu', 'opt', 'id'));
    }

    public function addtocart($id) {

        if (!Session::get('cart')) {

            $item = Food::where('food_id', '=', $id)->first()->toArray();
            $item['quantity'] = 1;
            $item['key']=uniqid();
            $cart = array(0 => $item, 'totalquantity' => 1);


            Session::put('cart', $cart);
            Session::put('currentrest', $item["rest_id"]);

            return "ok";
        } else {


            $item = Food::where('food_id', '=', $id)->first()->toArray();
            if (Session::get('currentrest') != $item["rest_id"]) {

                return "error";
            }

            $cart = Session::get('cart');

            Session::forget('cart');

            $key = array_search($id, array_column($cart, 'food_id'));

            if ($key !== false) {
                $cart[$key]['quantity'] ++;
                $cart['totalquantity'] ++;
                Session::put('cart', $cart);
                return "key contains ,quantity incremented";
            } else {
                $item = Food::where('food_id', '=', $id)->first()->toArray();
                $item['quantity'] = 1;
                $item['key']=uniqid();

                array_push($cart, $item);
                $cart['totalquantity'] ++;
                Session::put('cart', $cart);
                return "new item added";
            }
        }
    }

    public function addtocartsub($id) {



        if (!Session::get('cart')) {


            if (Input::has('dropdown')) {


                $subitem1 = \App\SubMenu::find(Input::get('dropdown'));
                //return $subitem;
            }
            if (Input::has('checkbox')) {


                $subitem2 = \App\SubMenu::find(Input::get('checkbox'));
                // return $subitem;
            }
            if (isset($subitem2)) {
                $subitem = $subitem1->merge($subitem2);
            } else {
                $subitem = $subitem1;
            }

            //return $subitem;
            //$subitem = \App\SubMenu::find($id);
            $item = Food::where('food_id', '=', $id)->first()->toArray();
            Session::put('currentrest', $item["rest_id"]);
            $item['quantity'] = 1;
             $item['key']=uniqid();
            $item['subitem'] = $subitem->toArray();
            //    return $item;
            $cart = array(0 => $item, 'totalquantity' => 1);


            Session::put('cart', $cart);
            return $cart;
        } 
        
        
        else {
           

            
              if (Input::has('dropdown')) {


                $subitem1 = \App\SubMenu::find(Input::get('dropdown'));
                //return $subitem;
            }
            if (Input::has('checkbox')) {


                $subitem2 = \App\SubMenu::find(Input::get('checkbox'));
                // return $subitem;
            }
            if (isset($subitem2)) {
                $subitem = $subitem1->merge($subitem2);
            } else {
                $subitem = $subitem1;
            }

            //return $subitem;
            //$subitem = \App\SubMenu::find($id);
              $cart = Session::get('cart');

            Session::forget('cart');
            $item = Food::where('food_id', '=', $id)->first()->toArray();
            if (Session::get('currentrest') != $item["rest_id"]) {

                return "error";
            }
            $item['quantity'] = 1;
             $item['key']=uniqid();
            $item['subitem'] = $subitem->toArray();
            
             array_push($cart, $item);
                $cart['totalquantity'] ++;
                Session::put('cart', $cart);
                 return $cart;
            
                    
//            $subitem = \App\SubMenu::find($id);
//            $item = Food::where('food_id', '=', $id)->first()->toArray();
            
//            $cart = Session::get('cart');
//
//            Session::forget('cart');
//
//            $key = array_search($subitem->food_id, array_column($cart, 'food_id'));
//
//
//            if ($key !== false) {
//                if ($cart[$key]['subitem']['id'] == $id) {
//
//                    $cart[$key]['quantity'] ++;
//                    $cart['totalquantity'] ++;
//                    Session::put('cart', $cart);
//                    return $cart;
//                } else {
//                    $subitem = \App\SubMenu::find($id);
//                    $item = Food::where('food_id', '=', $subitem->food_id)->first()->toArray();
//                    $item['quantity'] = 1;
//                    $item['subitem'] = $subitem->toArray();
//                    array_push($cart, $item);
//                    $cart['totalquantity'] ++;
//                    Session::put('cart', $cart);
//                    return $cart;
//                }
//            }
        }
    }

    public function cart() {

        // return (Session::get('cart'));

        if (!Session::has('cart')) {

            return Response::view('customer.cart')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {



            $cart = Session::get('cart');
           //return $cart;
            $subtotal = 0;

            foreach ($cart as $d) {

                if (is_array($d)) {
                  
                    if ($d['submenu_status'] == "1") {
                           $subtotal = $subtotal + floatval($d['food_price']);
                  
                         $subtotalsub=0;
                        foreach($d['subitem'] as $s) {
                            $subtotalsub =$subtotalsub + floatval($s['price']);
                  
                        }
                        
                        $subtotal = $subtotal+$subtotalsub*floatval($d['quantity']);
                       // $subtotal = $subtotal + ((floatval($d['food_price']) + floatval($d['subitem']['price'])) * floatval($d['quantity']));
                    } else {
                        $subtotal = $subtotal + (floatval($d['food_price']) * floatval($d['quantity']));
                    }
                }
            }
            $s = Shipping::first();
            $tax = round((floatval($s->tax) / 100) * $subtotal, 2);
            $shipping = isset($cart['promo_code']) && $this->validatePromoCode($cart['promo_code']) ? 0 : floatval($s->ship_price);
            $shippingtax = round((floatval($s->ship_tax) / 100) * $shipping, 2);

            //$shipping = round($shipping + $shippingtax,2);


            $drivertip = round(2.5, 2);
            $total = round($subtotal + $tax + $shipping+$shippingtax,2);
            return Response::view('customer.cart', compact('cart', 'subtotal', 'total', 'shipping', 'tax', 'shippingtax', 'drivertip'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }

    function validatePromoCode($promoCode) {
        $usePromoCode = false;
        if($promoCode != '' && Auth::user()) {
            $promotion = Promotion::where([
                ['user_id', '=', (int)Auth::user()->id],
                ['code', '=', $promoCode]
            ])->first();
            if(!empty($promotion)) {
                $promotionSetting = PromotionSetting::find($promotion->promotion_setting_id);
                //if the promotion is active and not expired
                if($promotionSetting->status && strtotime('Now') < strtotime($promotion->created_at . ' +' . $promotionSetting->expiry . 'days')) {
                    //if it is not used
                    if(($promotionSetting->usage == 1 && $promotion->used == 0) || $promotionSetting->usage == 0) {
                        $usePromoCode = true;
                    }
                }
            }
        }
        
        return $usePromoCode;
    }

    public function updatecart() {

        $cart = Session::get('cart');

        Session::forget('cart');
//return var_dump(Input::get('items'));
        foreach ($cart as $key => $value) {

            if (is_array($value)) {

                foreach (Input::get('items') as $k => $v) {
                    if ($value['key'] == $k) {
                        echo $v;
                        $cart[$key]['quantity'] = $v;
                    }
                }
            }
        }
//        foreach (Input::get('items') as $key => $value) {
//        //    return var_dump($key);
//            $k= array_search($key, array_column($cart, 'food_id'),true);
//            return var_dump($k);
//            if ($k !== false) {
//                $cart[$k]['quantity'] = $value;
//            }
//        }

        $totalquantity = 0;
        foreach ($cart as $c) {
            if(isset($c['quantity'])) {
                $totalquantity = $totalquantity + $c['quantity'];
            }
        }
        $cart['totalquantity'] = $totalquantity;var_dump($cart);
        if($this->validatePromoCode(Input::get('promo_code'))) {
            $cart['promo_code'] = Input::get('promo_code');
           
        } else {
            $cart['promo_code'] = '';
           
        }
        Session::put('cart', $cart);


        return redirect('/cart');
    }

    public function deletefromcart($id) {


        $cart = Session::get('cart');

        //Session::forget('cart');

        if (count($cart) == 2) {
            Session::forget('cart');
            Session::forget('currentrest');
            return redirect('/cart');
        } else {
            foreach ($cart as $key => $value) {

                if (is_array($value)) {

                    if ($value['key'] == $id) {
                        unset($cart[$key]);
                    }
                }


//                $k = array_search($id, array_column($cart, 'food_id'));
//                if ($k !== false) {
//                    unset($cart[$k]);
//                }
            }

            $totalquantity = 0;
            foreach ($cart as $c) {
                if(isset($c['quantity'])) {
                    $totalquantity = $totalquantity + $c['quantity'];
                }
            }
            $cart['totalquantity'] = $totalquantity;
            Session::put('cart', $cart);


            return redirect('/cart');
        }
    }

    public function checkout() {

//return Input::get("Stripetoken");


        if (Auth::check()) {
           
            
            
            if(Input::get("paymentmethod")=="cod") {
                
                
                 $cart = Session::get('cart');
            $restid = 0;
            foreach ($cart as $c) {
                if (is_array($c)) {
                    $restid = $c['rest_id'];
                }
            }

            $o = new OrderInfo;
            $o->cust_id = Auth::user()->id;
            $o->rest_id = $restid;
            $o->order_qty = $cart["totalquantity"];
            $o->created_at = Carbon::now();
            $o->order_status = "pending";
            $o->cart=serialize($cart);
            $o->save();
            $total = 0;
            foreach ($cart as $a) {
                if (is_array($a)) {
//                    $i = new Item;
//                    $i->itemid = $a['food_id'];
//                    $i->order_id = $o->order_id;
//                    $i->item_name = $a['food_name'];
//                    $i->item_price = $a['food_price'];
//                    $i->item_qty = $a['quantity'];

                    if ($a['submenu_status'] == "1") {
                        
                        $opsub=0;
                        foreach($a['subitem'] as $i) {
                            $opsub=$opsub+floatval($i['price']);
                        }
                        
                       // $i->subitem_id = $a['subitem']['id'];

                        $total = round($total + (floatval(($a['food_price']) + $opsub) * floatval($a['quantity'])), 2);
                      //  $i->save();
                    } else {
                        $total = round($total + (floatval($a['food_price']) * floatval($a['quantity'])), 2);
                      //  $i->save();
                    }
                }
            }

            $o->order_total_amount = $total;

            $drivertip = 0;
            if (Input::get('options') == "2.5") {
                $drivertip = 2.5;
                $o->drivertip = $drivertip;
            } else {

                $drivertip = round(floatval(15 / 100) * floatval($total), 2);
                $o->drivertip = $drivertip;
            }
		if (array_key_exists('promo_code', $cart)) {
		$usePromoCode = $this->validatePromoCode($cart['promo_code']);
		
		}
		else {
		$usePromoCode = $this->validatePromoCode("");
		
		}
            
            //save shipping address to the order info table
            $s = Shipping::first();
            $tax = (floatval($s->tax) / 100) * $total;
            $shipping = $usePromoCode ? 0 : floatval($s->ship_price);
            $shippingtax = (floatval($s->ship_tax) / 100) * $shipping;
            //$shipping = $shipping + $shippingtax;
            $grandtotal = $total + $tax + $shipping+$shippingtax+ $drivertip;
            $o->order_totalshipping = round(($shipping + $shippingtax), 2);
            $o->order_total_without_tax = round($total, 2);
            $o->order_tax = round($tax, 2);
            $o->order_ship_tax = round($shippingtax, 2);

            $o->order_ship_price = round($shipping, 2);
            $o->order_grand_total = round($grandtotal, 2);
            $o->order_print_status = 0; //zero means no print status

            //additonal information textarea 
             if (Input::has('type')) {
                $o->order_infocol = Input::get("additionalText");
                $o->save();
            } else {
                $o->order_infocol = Input::get("additionalText");
                $o->save();
            }




  

            if (Input::has('addresstype')) {
	$gsca = CustomerAddress::where('cus_id', Auth::user()->id)->where('address_type', 'ship')->first();
                $o->addresstype = "ship";
                $o->save();
                  $gsad = $gsca->street . ',' . $gsca->city . ',' . $gsca->country;
            } else {

	$gsca = CustomerAddress::where('cus_id', Auth::user()->id)->where('address_type', 'del')->first();

                $cusShipStreet = Input::get('street');
                $cusShipCity = Input::get('city');
                $cusShipState = Input::get('state');
                $cusShipCountry = Input::get('country');
                $cusShipZipCode = Input::get('zip');
                $cusShipPhoneNo = Input::get('phone');
$gsad = $cusShipStreet . ',' . $cusShipCity . ',' . $cusShipCountry;


                $cs = CustomerAddress::where('cus_id', Auth::user()->id)->where('address_type', 'del')->update([
                    'street' => $cusShipStreet,
                    'city' => $cusShipCity,
                    'country' => $cusShipCountry,
                    'zip_code' => $cusShipZipCode,
                    'state_province' => $cusShipState,
                    'phone_no' => $cusShipPhoneNo,
                    'cus_id' => Auth::user()->id,
                    'address_type' => 'del',
                ]);
                $o->addresstype = "del";
                $o->save();
            }


            if($usePromoCode) {
                $promotion = Promotion::where([
                    ['user_id', '=', (int)Auth::user()->id],
                    ['code', '=', $cart['promo_code']]
                ])->first();

                //save promo as used
                Promotion::updateOrCreate(
                    ['id' => $promotion['id']],
                    ['used' => $promotion['used'] + 1]
                );
            }


               $items = array();
             //   array_push($stack, array("test" => "test"), array("raspberry" => "sad"));
                // return json_encode($stack);
                $cartn = unserialize($o->cart);
                
                      // $cartn = unserialize($orderinfo->cart);
               // return $cartn;
              foreach ($cartn as $item) {
                    if (!is_array($item)) {
                        
                    }else {

                        if ($item['submenu_status'] == 1) {
                            $iname=$item['food_name'];
                            $iprice=floatval($item['food_price']);
                            
                            $subp=0;
                            foreach ($item['subitem'] as $s) {
                                $iname=$iname."(".$s['option'].":".$s['name'].")";
                                 $subp=$subp+floatval($s['price']);
                            }
                           
                           
                          
                             $iprice=$iprice+$subp;
                             
                              $i = array(
                              	
                                "sku" => $item['food_id'],
                                "quantity" => $item['quantity'],
                                "description"=>$iname,
                                
                                "price" =>$iprice
                            );
                            array_push($items, $i);
                        } else {

                            $i = array(
                                "description" => $item['food_name'],
                                "quantity" => $item['quantity'],
                                "sku" => $item['food_id'],
                                
                                "price" =>$item['food_price']
                            );
                            array_push($items, $i);
                        }
                    }
                }
                
                
                
                $des = "Grand Total : $" . $o->order_grand_total . ", time & date :" . $o->created_at ;



                $gsrest = Restaurant::where('rest_id', $restid)->first();
                           $client = new GuzzleHttp\Client();
                $res = $client->request('POST', 'https://app.getswift.co/api/v2/deliveries', [
                    'json' => [
                        'apiKey' => "782f3d88-160d-4170-9c0b-c929abe25cc6",
                        'booking' =>
                        ['reference'=> "#".$o->order_id,
                         'deliveryInstructions'=> $des,	
                        'items'=>$items,
                            'pickupDetail' =>
                            [
                            'name' => $gsrest->rest_name,
                                'phone' => $gsrest->rest_phone_no,
                                
                                'address' => $gsrest->rest_street.','.$gsrest->rest_city.','.$gsrest->rest_state_province.','.$gsrest->rest_country
                              
                            ],
                            'dropoffDetail' =>
                            [
                                'name' => Auth::user()->first_name." ".Auth::user()->last_name,
                                'phone' => $gsca->phone_no,
                              
                                'address' =>$gsad
                            ],
                            "webhooks" => [array(
                            "eventName" => "job/accepted",
                            "url" => "http://www.test.talkfood.ca/api/dispatch/".$o->order_id
                                )]
                        ]
                    ]
                ]);


            Session::forget('cart');
            return redirect('customer/orders')->with('message', 'You order is placed!');
                
                
            }
            else {
                
            
            $cart = Session::get('cart');
            $restid = 0;
            foreach ($cart as $c) {
                if (is_array($c)) {
                    $restid = $c['rest_id'];
                }
            }

            $o = new OrderInfo;
            $o->cust_id = Auth::user()->id;
            $o->rest_id = $restid;
            $o->order_qty = $cart["totalquantity"];
            $o->created_at = Carbon::now();
            $o->order_status = "pending";
            $o->cart=serialize($cart);
            $o->save();
            $total = 0;
            foreach ($cart as $a) {
                if (is_array($a)) {
//                    $i = new Item;
//                    $i->itemid = $a['food_id'];
//                    $i->order_id = $o->order_id;
//                    $i->item_name = $a['food_name'];
//                    $i->item_price = $a['food_price'];
//                    $i->item_qty = $a['quantity'];

                    if ($a['submenu_status'] == "1") {
                        
                        $opsub=0;
                        foreach($a['subitem'] as $i) {
                            $opsub=$opsub+floatval($i['price']);
                        }
                        
                       // $i->subitem_id = $a['subitem']['id'];

                        $total = round($total + (floatval(($a['food_price']) + $opsub) * floatval($a['quantity'])), 2);
                      //  $i->save();
                    } else {
                        $total = round($total + (floatval($a['food_price']) * floatval($a['quantity'])), 2);
                      //  $i->save();
                    }
                }
            }

            $o->order_total_amount = $total;

            $drivertip = 0;
            if (Input::get('options') == "2.5") {
                $drivertip = 2.5;
                $o->drivertip = $drivertip;
            } else {

                $drivertip = round(floatval(15 / 100) * floatval($total), 2);
                $o->drivertip = $drivertip;
            }

          if (array_key_exists('promo_code', $cart)) {
		$usePromoCode = $this->validatePromoCode($cart['promo_code']);
		
		}
		else {
		$usePromoCode = $this->validatePromoCode("");
		}
            //save shipping address to the order info table
            $s = Shipping::first();
            $tax = (floatval($s->tax) / 100) * $total;
            $shipping = $usePromoCode ? 0 : floatval($s->ship_price);
            $shippingtax = (floatval($s->ship_tax) / 100) * $shipping;
            //$shipping = $shipping + $shippingtax;
            $grandtotal = $total + $tax + $shipping+$shippingtax+ $drivertip;
            $o->order_totalshipping = round(($shipping + $shippingtax), 2);
            $o->order_total_without_tax = round($total, 2);
            $o->order_tax = round($tax, 2);
            $o->order_ship_tax = round($shippingtax, 2);

            $o->order_ship_price = round($shipping, 2);
            $o->order_grand_total = round($grandtotal, 2);
            $o->order_print_status = 0; //zero means no print status



            //additonal information textarea 
             if (Input::has('type')) {
                $o->order_infocol = Input::get("additionalText");
                $o->save();
            } else {
                $o->order_infocol = Input::get("additionalText");
                $o->save();
            }

 

            if (Input::has('addresstype')) {
 $gsca = CustomerAddress::where('cus_id', Auth::user()->id)->where('address_type', 'ship')->first();

                $o->addresstype = "ship";
                $o->save();
                $gsad = $gsca->street . ',' . $gsca->city . ',' . $gsca->country;
            } else {

 $gsca = CustomerAddress::where('cus_id', Auth::user()->id)->where('address_type', 'del')->first();
                $cusShipStreet = Input::get('street');
                $cusShipCity = Input::get('city');
                $cusShipState = Input::get('state');
                $cusShipCountry = Input::get('country');
                $cusShipZipCode = Input::get('zip');
                $cusShipPhoneNo = Input::get('phone');
   $gsad = $cusShipStreet . ',' . $cusShipCity . ',' . $cusShipCountry;
                 

                $cs = CustomerAddress::where('cus_id', Auth::user()->id)->where('address_type', 'del')->update([
                    'street' => $cusShipStreet,
                    'city' => $cusShipCity,
                    'country' => $cusShipCountry,
                    'zip_code' => $cusShipZipCode,
                    'state_province' => $cusShipState,
                    'phone_no' => $cusShipPhoneNo,
                    'cus_id' => Auth::user()->id,
                    'address_type' => 'del',
                ]);
                $o->addresstype = "del";
                $o->save();
            }


            if($usePromoCode) {
                $promotion = Promotion::where([
                    ['user_id', '=', (int)Auth::user()->id],
                    ['code', '=', $cart['promo_code']]
                ])->first();

                //save promo as used
                Promotion::updateOrCreate(
                    ['id' => $promotion['id']],
                    ['used' => $promotion['used'] + 1]
                );
            }


             Stripe::setApiKey('sk_test_dyBI9IPQOXCqRy7dJYZ3YA0h');
            try {
                
               $charge=Charge::create(array(
                    "amount"=>$o->order_grand_total*100,
                    "currency"=>"cad",
                    "source"=>Input::get("Stripetoken"),
                    "description"=>"Payment for #order: ".$o->order_id
                    
                    
                    
                    
                ));
               
               $o->paymentid=$charge->id;
               $o->save();
               
               
                    $items = array();
             //   array_push($stack, array("test" => "test"), array("raspberry" => "sad"));
                // return json_encode($stack);
                $cartn = unserialize($o->cart);
                
                      // $cartn = unserialize($orderinfo->cart);
               // return $cartn;
              foreach ($cartn as $item) {
                    if (!is_array($item)) {
                        
                    }else {

                        if ($item['submenu_status'] == 1) {
                            $iname=$item['food_name'];
                            $iprice=floatval($item['food_price']);
                            
                            $subp=0;
                            foreach ($item['subitem'] as $s) {
                                $iname=$iname."(".$s['option'].":".$s['name'].")";
                                 $subp=$subp+floatval($s['price']);
                            }
                           
                           
                          
                             $iprice=$iprice+$subp;
                             
                              $i = array(
                              	
                                "sku" => $item['food_id'],
                                "quantity" => $item['quantity'],
                                "description"=>$iname,
                                
                                "price" =>$iprice
                            );
                            array_push($items, $i);
                        } else {

                            $i = array(
                                "description" => $item['food_name'],
                                "quantity" => $item['quantity'],
                                "sku" => $item['food_id'],
                                
                                "price" =>$item['food_price']
                            );
                            array_push($items, $i);
                        }
                    }
                }
                
                
                
              $des = "PAID , time & date :" . $o->created_at ;


                $gsrest = Restaurant::where('rest_id', $restid)->first();
                           $client = new GuzzleHttp\Client();
                $res = $client->request('POST', 'https://app.getswift.co/api/v2/deliveries', [
                    'json' => [
                        'apiKey' => "782f3d88-160d-4170-9c0b-c929abe25cc6",
                        'booking' =>
                        ['reference'=> "#".$o->order_id,
                         'deliveryInstructions'=> $des,		
                         'items'=>$items,
                            'pickupDetail' =>
                            [
                                 'name' => $gsrest->rest_name,
                                'phone' => $gsrest->rest_phone_no,
                                
                                'address' => $gsrest->rest_street.','.$gsrest->rest_city.','.$gsrest->rest_state_province.','.$gsrest->rest_country
                            ],
                            'dropoffDetail' =>
                            [
                            'name' => Auth::user()->first_name." ".Auth::user()->last_name,
                                'phone' => $gsca->phone_no,
                              
                                'address' =>$gsad
                               
                            ],
                            "webhooks" => [array(
                            "eventName" => "job/accepted",
                            "url" => "http://www.test.talkfood.ca/api/dispatch/".$o->order_id
                                )]
                        ]
                    ]
                ]);
               
               
               
               
               
               
               
               
            } catch (Exception $ex) {
return $ex->getMessage();
            }

            Session::forget('cart');
            return redirect('customer/orders')->with('message', 'You order is placed!');
        }
        } else {

            return redirect('/signup?returnurl=checkout');
        }
    }

    public function orders() {

        $orders = OrderInfo::where('cust_id', Auth::user()->id)->orderBy('order_id', 'desc')->get();
        return view('customer.orders', compact('orders'));
    }

    public function orderdetails($id) {

        
        $data = restdashboard::orderdetailData($id);
        $orderinfo =  OrderInfo::with('customer')->where('order_id', $id)->first();
        $customeraddress = CustomerAddress::where('cus_id', $orderinfo['customer']->id)->get();
        $orderinfo['customerAddress'] = $customeraddress[0];
//        $items = $data[1];
//        foreach ($items as $key => $value) {
//
//            if ($value->subitem_id != null) {
//                $subitem = \App\SubMenu::find($value->subitem_id);
//                $items[$key]['subitem'] = $subitem;
//            }
//        }
        $subtotal = $orderinfo->order_total_amount;
        $cart=  unserialize($orderinfo->cart);
       
        // $s= Shipping::first();
        //    $tax= ($s->tax/100)*$subtotal;
        //   $shipping=$s->ship_price;
        //   $shippingtax=($s->ship_tax/100) *$shipping;
        //  $shipping= $shipping+$shippingtax;
        // $total=$subtotal+$tax+$shipping;

        $s = Shipping::first();
        $tax = (floatval($s->tax) / 100) * $subtotal;
        $shipping = floatval($s->ship_price);
        $shippingtax = (floatval($s->ship_tax) / 100) * $shipping;
        $shipping = $shipping + $shippingtax;
        $total = $subtotal + $tax + $shipping;


        // return var_dump($items->toArray());
        return view('customer.orderdetails', compact('orderinfo', 'total','cart'));
    }

    public function account() {

        $user = User::where('id', Auth::user()->id)->get();
        $cus = CustomerAddress::where('cus_id', Auth::user()->id)->get();
        if(!empty($files = glob('uploads/' . Auth::user()->id . '.*'))) {
            $photo = $files[0];
        }
        return view('customer.account', compact('user', 'cus', 'photo'));
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


            $user = User::where('id', Auth::user()->id)->update([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $emailNo
            ]);


            $ship_adress = CustomerAddress::where('cus_id', Auth::user()->id)->where('address_type', 'ship')->update([
                'street' => $cusShipStreet,
                'city' => $cusShipCity,
                'country' => $cusShipCountry,
                'zip_code' => $cusShipZipCode,
                'state_province' => $cusShipState,
                'phone_no' => $cusShipPhoneNo,
                'cus_id' => Auth::user()->id,
                'address_type' => 'ship',
            ]);
            $bill_adress = CustomerAddress::where('cus_id', Auth::user()->id)->where('address_type', 'bill')->update([
                'street' => $cusBillStreet,
                'city' => $cusBillCity,
                'country' => $cusBillCountry,
                'zip_code' => $cusBillZipCode,
                'state_province' => $cusBillState,
                'phone_no' => $cusBillPhoneNo,
                'cus_id' => Auth::user()->id,
                'address_type' => 'bill',
            ]);
            if (Input::file('photo')->isValid()) {
                if(!empty($files = glob('uploads/' . Auth::user()->id . '.*'))) {
                    $photo = $files[0];
                    unlink($photo);
                }
                Input::file('photo')->move('uploads', Auth::user()->id . '.' . Input::file('photo')->getClientOriginalExtension());
            }
            return Redirect::to('customer/account')->with('message', 'Account information updated.');
        } else {
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
                ->where('restaurant_table.rest_status', 'active')
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
