<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use App\User;
use App\Shipping;
use App\Http\Requests;
use App\Commision;
use App\CustomerAddress;
use App\Http\Controllers\restdashboard;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\OrderInfo;
use App\Food;
use App\Customer;
use App\SubMenu;
use App\PromotionSetting;
use App\Promotion;


class dashboard extends Controller
{
    //dashboard index function for main view
    public function index()
    {
        $rests=Restaurant::paginate(15);
        return view('admin.index',compact('rests'));
    }
    
    public function viewcustomer()
    {
        $rests=User::where('role','cus')->paginate(15);
        return view('admin.viewcustomer',compact('rests'));
    }
    
    public function deleteCustomer($id)
    {
        User::where('id',$id)->first()->delete();
        CustomerAddress::where('cus_id',$id)->delete();
        return Redirect('/admin/viewcustomer');
    }
    
    public function viewCustomerAddress($id)
    {
    	$custdetail=User::where('id',$id)->first();
        $custAddress=CustomerAddress::where('cus_id',$id)->get();
        
        $oncePromotionElligible = PromotionSetting::find(1)->status;
        $manyTimesPromotionElligible = PromotionSetting::find(2)->status;
        $promotions = Promotion::where('user_id', $id)->get();
        $promotionSettings = PromotionSetting::lists('name', 'id')->all();
        $promotionSettingsExpiry = PromotionSetting::lists('expiry', 'id')->all();
    	return view('admin.viewCustomerAddress',compact('custdetail','custAddress', 'oncePromotionElligible', 'manyTimesPromotionElligible', 'promotions', 'promotionSettings', 'promotionSettingsExpiry'));
    }
    
    public function editRest( $id){
        $commiso= Commision::all();
        $resto= Restaurant::where('rest_id', $id)->first();
        $usero=User::find($resto->rest_user_id);
        
       
        
       return view('admin.editrest',compact('resto','usero','commiso'));
    }
    public function doEditRest(){
        $rest_id=Input::get('rest_id');
        $restname=Input::get('restname');        
        $firstname=Input::get('firstname');
        $lastname=Input::get('lastname');
        
        $commis_group=Input::get('commis_group');
        $email=Input::get('email');
        $phoneno=Input::get('phone_no');
        $status=Input::get('status');
        $kitchen_type=Input::get('kitchen_type');
        $street=Input::get('street');
        $city=Input::get('city');
        $province=Input::get('province');
        $country=Input::get('country');
        $zip_code=Input::get('zip_code'); 
        $us=  Restaurant::where('rest_id',$rest_id)->first();
        $user=User::find($us->rest_user_id);
        $user->first_name=$firstname;        
        $user->last_name=$lastname;        
      //  $user->email=$email;
        $user->save();
        
        Restaurant::where('rest_id', $rest_id)
          ->update(['rest_name' => $restname,
              'rest_phone_no' => $phoneno,
              'rest_status' => $status,
              'kitchen_type' => $kitchen_type,
              'rest_street' => $street,
              'rest_city' => $city,
              'commis_id'=>$commis_group,
              'rest_state_province' => $province,
              'rest_country' => $country,
              'rest_postal_code' => $zip_code]);
        
        $rests=Restaurant::paginate(15);
        return view('admin.index',compact('rests'));
    }
    
    public function settings(){       
        $ship=Shipping::find(1);
        return view('admin.setting',compact('ship'));
    }
    public function doSettings(){
    $ship=Shipping::updateOrCreate(
                ['id' =>1],
                [ 'ship_price' =>Input::get('ship_price'),
                'ship_tax' => Input::get('ship_tax'),
                'tax' => Input::get('tax'),
                'driver_tip' => Input::get('driver_tip')]);
                
        return view('admin.setting',compact('ship'));
    }
    
    public function commision(){
        $comms=Commision::all();
        return view('admin.commision.index',compact('comms'));
    }
    
       public function addCommision(){
        return view('admin.commision.create');
    }
    
    public function storeCommision(){
       Commision::create([
            'commis_type'=>Input::get('commis_type'),
            'commis_percent'=>Input::get('commis_percent')
        ]);
        return Redirect('/admin/commission');
    }
    public function delCommision($id){
        Commision::where('commis_id',$id)->delete();
        return Redirect('/admin/commission');
    }
    public function viewOrders($id){
    
       $orderdetail=OrderInfo::with('customer')->where('rest_id',$id)->orderBy('order_id','Desc')->paginate(15);
        
        return view('admin.vieworders', compact('orderdetail'));
}
    public function viewOrderDetails($id){
       
            
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
        return view('admin.vieworderdetails', compact('orderinfo', 'cart', 'total'));
    }
    
 //View Sale Report
    public function viewSaleReport($id,Request $request){
        $dateFrom='';
        $dateTo='';
       //$user = Auth::user();
        $restId = Restaurant::where('rest_id',$id)->first()->rest_id;
        if(isset($request->query()['page']))
        {
            $dateFrom=Session::get('dateFrom');
            $dateTo=Session::get('dateTo');
        }
        else
        {
            $dateFrom=Input::get('dateFrom');
            Session::put('dateFrom',$dateFrom);
            $dateTo=Input::get('dateTo');
            Session::put('dateTo',$dateTo);
        }
        $orderdetail=OrderInfo::with('customer')
                    ->where('rest_id',$restId)
                   ->where('order_status','complete')
                    ->where('created_at','>=',Carbon::createFromFormat('m/d/Y', $dateFrom))
                    ->where('created_at','<=',Carbon::createFromFormat('m/d/Y', $dateTo));
        $totalAmount=0;
        foreach($orderdetail->get()->toArray() as $order)
        {
            $totalAmount+=$order['order_total_amount'];
        }
        $orderdetail=$orderdetail->paginate(10);
        return view('admin.report.index',compact('orderdetail','dateFrom','dateTo','totalAmount','id'));
    }

    public function SaleReport($id){
        return view('admin.report.index',  compact('id'));
    }
    
    
    public function deleteRest($id){
   
        $r=Restaurant::where('rest_id',$id)->first();
        User::where('id',$r->rest_id)->delete();
        OrderInfo::where('rest_id',$id)->delete();
        $f =Food::where('rest_id',$id)->get();
       
        foreach($f as $food)
        {
        
        SubMenu::where('food_id',$food->food_id)->delete();
        
        
        }
        Food::where('rest_id',$id)->delete();
        Restaurant::where('rest_id',$id)->delete();
        
        return redirect('admin/index');
    }
    
      public function viewallorders() {
        
        if(Input::has('search')) {
        
        if(Input::get('search')=="all") {
        $orderdetail=OrderInfo::with('customer')->orderBy('order_id','Desc')->paginate(15);
        
        }
        
        elseif(Input::get('search')=="pending") {
         $orderdetail=OrderInfo::with('customer')->where('order_status','pending')->orderBy('order_id','Desc')->paginate(15);
    
           } 
           
          elseif(Input::get('search')=="processing") {
        
      $orderdetail=OrderInfo::with('customer')->where('order_status','processing')->orderBy('order_id','Desc')->paginate(15);
           } 
           
            elseif(Input::get('search')=="complete") {
          $orderdetail=OrderInfo::with('customer')->where('order_status','complete')->orderBy('order_id','Desc')->paginate(15);
    
           } 
           
            elseif(Input::get('search')=="canceled") {
          $orderdetail=OrderInfo::with('customer')->where('order_status','canceled')->orderBy('order_id','Desc')->paginate(15);
    
           } 
        }
        
        else {
            $orderdetail=OrderInfo::with('customer')->orderBy('order_id','Desc')->paginate(15);
            //  dd(count($orderdetail));
        }
          
        
        return view('admin.allorders', compact('orderdetail'));
    }
    
    public function viewallOrderDetails($id) {
        
           $data = restdashboard::orderdetailData($id);
        $orderinfo =  OrderInfo::with('customer')->where('order_id', $id)->first();
         $orderstatus =  OrderInfo::where('order_id', $id)->first();
        
        $customeraddress = CustomerAddress::where('cus_id', $orderinfo['customer']->id)->get();
        $orderinfo['customerAddress'] = $customeraddress[0];
        $restName=Restaurant::where('rest_id',$orderinfo->rest_id)->first()->rest_name;
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

if($orderstatus->order_status=="pending") {

 $orderstatus->order_status="processing";
 $orderstatus->save();
}
       
        // return var_dump($items->toArray());
        return view('admin.viewallorderdetails', compact('orderinfo', 'cart', 'total','orderstatus','restName'));
    }
    
     public function viewallOrderdelete($id) {
         
           $orderstatus =  OrderInfo::where('order_id', $id)->delete();
            return redirect('admin/allorders');
           
         
     }
    
    
    
}
