<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;
use App\User;
use App\Category;
use App\Restaurant;
use App\CustomerAddress;
use App\Shipping;
use App\OrderInfo;
use App\Item;
use App\Food;
use App\SubMenu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class restdashboard extends Controller {

    // Order Dashboard
    public function index() {
        $user = Auth::user();
        $userData = Restaurant::where('rest_user_id', $user->id)->first();
        $orderdetail = OrderInfo::with('customer')->where('rest_id', $userData->rest_id)->orderBy('order_id','Desc')->paginate(15);
        return view('restaurant.index', compact('orderdetail'));
    }

    public function vieworderdetail($id) {
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

        //return view('restaurant.orderDetail', compact('orderdetail', 'orderItemDetail', 'counter'));
        return view('restaurant.orderDetail', compact('orderinfo', 'cart', 'total'));
    }

    public function editOrderDetail($id) {
        $order = OrderInfo::where('order_id', $id)->first();
        $order->order_status = Input::get('status');
        $order->save();
        return redirect('restaurant/index');
    }

    public function index12() {
        return view('restaurant.food.category');
    }

    //Food Tab
    public function viewMenuItem() {
        $user = Auth::user();
        $userData = Restaurant::where('rest_user_id', $user->id)->first();
        $foodDetail = Food::with('foodCategory')->where('rest_id', $userData->rest_id)->orderBy('food_id','Desc')->paginate(15);
        return view('restaurant.food.viewFood', compact('foodDetail'));
    }

    public function viewMenuWithSubItem($id) {
        $user = Auth::user();
        $userData = Restaurant::where('rest_user_id', $user->id)->first();
        $foodDetail = Food::with('foodCategory')->where('rest_id', $userData->rest_id)->paginate(15);
        $subfood = SubMenu::where('food_id', $id)->get();
        return view('restaurant.food.viewFood', compact('foodDetail', 'subfood'));
    }

    public function viewSubItem($id) {
        $subfood = SubMenu::where('id', $id)->first();
        $food = Food::where('food_id', $subfood->food_id)->first();
        return view('restaurant.food.editsubitem', compact('food', 'subfood'));
    }

    public function editSubItem($id) {
        
        $subfood= SubMenu::where('id', $id)->first();
        $subfood->name = Input::get('name');
        $subfood->desc = Input::get('desc');
        $subfood->price = Input::get('price');
        $subfood->save();
        $food = Food::where('food_id', $subfood->food_id)->first();
        return view('restaurant.food.editsubitem', compact('food', 'subfood'));
    }

    public function MenuItem() {
        
        $user = Auth::user();
        $rest = Restaurant::where('rest_user_id', $user->id)->first();
        $categs = Category::where('rest_id', $rest->rest_id)->get();
        return view('restaurant.food.food', compact('categs'));
    }

    public function createMenuItem() {
        
      // return Input::all();
        $subcount = Input::get('submenutext');
        $user = Auth::user();
        $rest = Restaurant::where('rest_user_id', $user->id)->first();
        
       if(!Input::has('option')) {
            Food::create([
                'food_name' => Input::get('food'),
                'food_desc' => Input::get('description'),
                'food_price' => Input::get('price'),
                'cate_id' => Input::get('categ_id'),
                'food_pic_path' => '',
                'rest_id' => $rest->rest_id,
                'submenu_status' => false
            ]);
            
        } else {
            $food = Food::create([
                        'food_name' => Input::get('food'),
                        'food_desc' => Input::get('description'),
                        'food_price' => Input::get('price'),
                        'cate_id' => Input::get('categ_id'),
                        'food_pic_path' => '',
                        'rest_id' => $rest->rest_id,
                        'submenu_status' => true
            ]);
          //  $subcount = Input::get('submenutext');
            foreach(Input::get('option') as $s) {
                
              //  return var_dump($s);
                
                    foreach($s['subopt'] as $e) {
                        
                        
                           SubMenu::create([
                    'name' => $e['name'],
                    'desc' => "",
                    'price' => $e['price'],
                    'option' => $s['name'],
                    'type'=>$s['type'],
                    'food_id' => $food->food_id
                ]);
//                        
                    }
              
            }
           
        }



        return redirect('/restaurant/viewmenuitem');
    }

    public function deleteMenuItem($id) {
        //$user = Auth::user();
        //$rest = Restaurant::where('rest_user_id', $user->id)->first();
        
        Food::where('food_id',$id)->delete();
        SubMenu::where('food_id',$id)->delete();
        return redirect('/restaurant/viewmenuitem');
        
    }

    public function editMenuItem($id) {
        $user = Auth::user();
        $rest = Restaurant::where('rest_user_id', $user->id)->first();
        $categs = Category::where('rest_id', $rest->rest_id)->get();
        $food = Food::where('food_id', $id)->first();
        $submenu=  SubMenu::where('food_id',$id)->get();
         $opt = DB::table('menu_option')
                ->select('type', 'option')
                ->where('food_id', $id)
                ->distinct()
                ->get();
        return view('restaurant.food.editFood', compact('food', 'categs','submenu','opt'));
    }

    public function doEditMenuItem($id) {
        
             $subcount = Input::get('submenutext');
        $user = Auth::user();
        $rest = Restaurant::where('rest_user_id', $user->id)->first();
        
       if(!Input::has('option')) {
            Food::where('food_id',$id)->update([
                'food_name' => Input::get('food'),
                'food_desc' => Input::get('description'),
                'food_price' => Input::get('price'),
                'cate_id' => Input::get('categ_id'),
                'food_pic_path' => '',
                'rest_id' => $rest->rest_id,
                'submenu_status' => false
            ]);
             SubMenu::where('food_id',$id)->delete();
            
        } else {
            $food = Food::where('food_id',$id)->update([
                        'food_name' => Input::get('food'),
                        'food_desc' => Input::get('description'),
                        'food_price' => Input::get('price'),
                        'cate_id' => Input::get('categ_id'),
                        'food_pic_path' => '',
                        'rest_id' => $rest->rest_id,
                        'submenu_status' => true
            ]);
           // $subcount = Input::get('submenutext');
             SubMenu::where('food_id',$id)->delete();
          
                foreach(Input::get('option') as $s) {
                
              //  return var_dump($s);
                
                    foreach($s['subopt'] as $e) {
                        
                        
                           SubMenu::create([
                    'name' => $e['name'],
                    'desc' => "",
                    'price' => $e['price'],
                    'option' => $s['name'],
                    'type'=>$s['type'],
                    'food_id' =>$id
                ]);
//                        
                    }
              
            }
             
           
        }



        return redirect('/restaurant/viewmenuitem');
        
//        $food = Food::where('food_id', $id)->first();
//        $food->food_name = Input::get('food');
//        $food->food_desc = Input::get('description');
//        $food->food_price = Input::get('price');
//        $food->cate_id = Input::get('categ_id');
//        $food->save();
//        return redirect('/restaurant/viewmenuitem');
    }

    //Category Submenu
    public function viewCategory() {
        $user = Auth::user();
        $userData = Restaurant::where('rest_user_id', $user->id)->first();
        $catDetail = Category::where('rest_id', $userData->rest_id)->paginate(15);
        return view('restaurant.food.category', compact('catDetail'));
    }

    public function createCategory() {
        $user = Auth::user();
        $userData = Restaurant::where('rest_user_id', $user->id)->first();
        $category = new Category();
        $category->cate_name = Input::get('CategoryType');
        $category->rest_id = $userData->rest_id; //rest_id which is auto increment will be used
        $category->save();
        return redirect('restaurant/viewcategory')->with('success', 'Successfully added');
    }

    public function deleteCategory($id) {
        $user = Auth::user();
        $userData = Restaurant::where('rest_user_id', $user->id)->first();
        $catDetail = Category::where('rest_id', $userData->rest_id)->where('cate_id', $id);
        $catDetail->delete();
        return redirect('restaurant/viewcategory')->with('success', 'Successfully deleted');
    }

    //Profile Menu
    public function viewProfile() {
        $user = Auth::user();
        $restInfo = Restaurant::where('rest_user_id', $user->id)->first();
        return view('restaurant.profile', compact('user', 'restInfo'));
    }

    public function edit() {
        $user = Auth::user();
        $restResp = Restaurant::where('rest_user_id', $user->id)->first();
        $restResp->rest_name = Input::get('rname');
        $restResp->kitchen_type = Input::get('ktype');
        $restResp->rest_street = Input::get('rstreet');
        $restResp->rest_city = Input::get('rcity');
        $restResp->rest_country = Input::get('rcountry');
        $restResp->rest_postal_code = Input::get('rpostal');

        if (Input::file('rlogo')) {
            $destinationPath = 'uploads'; // upload path
            $imageName = Input::file('rest_logo')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $imageName; // renameing image
            Input::file('rest_logo')->move($destinationPath, $fileName); // uploading file to given path    
        }
        $restResp->rest_logo_path = $fileName;
        $restResp->rest_state_province = Input::get('rstpr');
        $restResp->rest_phone_no = Input::get('phone');
        $restResp->save();
        return redirect('restaurant/viewprofile');
    }
    
    // Update Availibility
    public function updateAvailibility(Request $request)
    {
        $user = Auth::user();
        $rest = Restaurant::where('rest_user_id', $user->id)->first();
        $storeQ=$request->get('status');
        $rest->rest_avail=$storeQ;
        $rest->save();
        return $storeQ;
    }
	
    // Admin Dashboard
    static public function restaurantOrderList($id) {

        $userData = Restaurant::where('rest_user_id', $user->id)->first();
        $orderdetail = OrderInfo::with('customer')->where('rest_id', $userData->rest_id);
        return Array($orderdetail);
    }

    //Customer Frontend //Admin Order Details
    static public function orderdetailData($id) {
        $orderdetail = OrderInfo::with('customer')->where('order_id', $id)->first();
        $orderItemDetail = Item::where('order_id', $id)->get();
        return Array($orderdetail, $orderItemDetail);
    }
    
  //View Sale Report
    public function viewSaleReport(Request $request){
        $dateFrom='';
        $dateTo='';
        $user = Auth::user();
        $restId = Restaurant::where('rest_user_id', $user->id)->first()->rest_id;
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
        return view('restaurant.report.index',compact('orderdetail','dateFrom','dateTo','totalAmount'));
    }

    public function SaleReport(Request $request){
        return view('restaurant.report.index');
    }
    
   
    
    

}
