<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\OrderInfo;
use App\Restaurant;

Route::get('gz',function(){



$orderinfo=OrderInfo::where('order_id',73)->first();
	
			$items = array();
                  $cartn = unserialize($orderinfo->cart);
               return $cartn["promo_code"];
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
                $o=$orderinfo;
                
$des="Order id: ".$o->order_id.",Grand Total : ". $o->order_grand_total.",Created at :".$o->created_at.",";


                    
$gsrest=  Restaurant::where('rest_id',9)->first();
                $client = new GuzzleHttp\Client();
                $res = $client->request('POST', 'https://app.getswift.co/api/v2/deliveries', [
                    'json' => [
                        'apiKey' => "782f3d88-160d-4170-9c0b-c929abe25cc6",
                        'booking' =>
                        [	'items'=>$items,
                            'pickupDetail' =>
                            [
                                'name' => "test",
                                'phone' => "asd",
                               "description" =>$des,
                                'address' =>"121 carman avenue, federation, New Brunswick,canada"
                            ],
                            'dropoffDetail' =>
                            [
                                'name' => $gsrest->rest_name,
                                'phone' => $gsrest->rest_phone_no,
                                  "description" =>$des,
                                'address' => $gsrest->rest_street.','.$gsrest->rest_city.','.$gsrest->rest_state_province.','.$gsrest->rest_country
                            ],
                            "webhooks" => [array(
                            "eventName" => "job/accepted",
                            "url" => "http://www.test.talkfood.ca/api/dispatch/".$o->order_id
                                )]
                        ]
                    ]
                ]);





    echo $res->getBody();

    return 1;
    
});

Route::get('/google',function(Illuminate\Support\Facades\Request $r){
//	$r=app('geocoder')->using('chain')->geocode('Block D-4 , Flat 6,Islamabad,44000,Pakistan')->all();
//	var_dump($r[0]->getCoordinates()->getLongitude());
    
    return var_dump($r->toArray());
    
});




Route::get('/sheep',function() {

return view('sheep');
});


    
    Route::get('/api/getorders','api@OrderFetch');
    Route::post('/api/addprint/{id}','api@addprint');
    Route::match(['get', 'post'], '/api/dispatch/{id}','api@dispatch');


Route::post('/api/login','api@login');


//Customer Route Frontend

Route::get('/','customer@index');
Route::get('/search/{lat}/{lng}','customer@search');
Route::get('/rest/{id}','customer@menu');
Route::get('/addtocart/{id}','customer@addtocart');
Route::get('/addtocartsub/{id}','customer@addtocartsub');
Route::get('/submenu/{id}','customer@viewsubmenu');
Route::get('/cart','customer@cart');
Route::post('/updatecart','customer@updatecart');
Route::get('/cart/delete/{id}','customer@deletefromcart');
Route::post('/cart/checkout','customer@checkout');
Route::get('customer/orders','customer@orders');
Route::get('customer/orders/{id}','customer@orderdetails');
Route::get('customer/account','customer@account');
Route::post('customer/account','customer@accountupdate');

//main
Route::get('/waleed', function () {
    return view('welcome');
});

//signUp
// Route::get('signup','signup@signup');
Route::get('signup',function(){
    return view('signup');
});
Route::get('signup/email','signup@signup');
Route::get('logout','signup@signout');
Route::post('signup/store','signup@doSignUp');

//login
Route::get('login','login@login');
Route::post('login','login@dologin');

//social
Route::get('auth/facebook','SocialController@redirectToProvider');
Route::get('auth/facebook/callback','SocialController@handleProviderCallback');

Route::get('auth/google','SocialController@googleRedirectToProvider');
Route::get('auth/google/callback','SocialController@googleHandleProviderCallback');

Route::get('auth/linkedin','SocialController@linkedinRedirectToProvider');
Route::get('auth/linkedin/callback','SocialController@linkedinHandleProviderCallback');

Route::get('auth/twitter','SocialController@twitterRedirectToProvider');
Route::get('auth/twitter/callback','SocialController@twitterHandleProviderCallback');

//reset password
Route::get('forgotPassword','users@forgotPassword');
Route::post('forgotPassword','users@doForgotPassword');
Route::get('resetPassword/{token}','users@resetForgotPassword');
Route::post('resetPassword/{token}','users@doResetForgotPassword');

Route::group(['middleware' => 'adminMiddleware'], function () {
//admin
Route::get('admin/viewcustomer','dashboard@viewcustomer');
Route::get('admin/viewCustomerAddress/{id}','dashboard@viewCustomerAddress');
Route::get('admin/deleteCustomer/{id}','dashboard@deleteCustomer');
Route::get('admin/index','dashboard@index');
Route::post('admin/createrest','dashboard@index');
Route::post('admin/editrest','dashboard@editRest');
Route::get('admin/editrest/{id}','dashboard@editRest');
Route::post('admin/editrest/edit','dashboard@doEditRest');
Route::get('admin/deleterest/{id}','dashboard@deleteRest');
Route::post('admin/modifystatus', 'dashboard@modifyRest');
Route::get('admin/settings','dashboard@settings');
Route::post('admin/settings','dashboard@doSettings');
Route::get('admin/commission','dashboard@commision');
Route::get('admin/commission/delete/{id}','dashboard@delCommision');
Route::get('admin/commission/create','dashboard@addCommision');
Route::post('admin/commission/create','dashboard@storeCommision');
Route::get('admin/vieworders/{id}','dashboard@viewOrders');
Route::get('admin/vieworderdetails/{id}','dashboard@viewOrderDetails');

Route::get('admin/{id}/salereport','dashboard@SaleReport');
Route::get('admin/{id}/viewsalereport','dashboard@ViewSaleReport');
Route::get('admin/promotions','promotions@index');
Route::get('admin/editPromotionSetting/{id}','promotions@editSetting');
Route::post('admin/editPromotionSetting/{id}','promotions@changeSetting');
Route::post('admin/addPromotion','promotions@addPromotion');
Route::get('admin/deletePromotion/{id}','promotions@deletePromotion');
Route::get('admin/resetPassword/{id}','users@resetPassword');
Route::post('admin/resetPassword/{id}','users@doResetPassword');

Route::get('admin/allorders', 'dashboard@viewallorders');
Route::get('admin/viewallorderdetails/{id}', 'dashboard@viewallOrderDetails');
Route::get('admin/viewallorderdetails/delete/{id}', 'dashboard@viewallOrderdelete');

// New Added Functions
// Update Availibility Status of All Resturants
Route::post('admin/updatestatus','newdashboard@updateStatus');
Route::get('admin/updateavailibility/{status}','newdashboard@updateAvailibility');
Route::get('admin/viewcategory','newdashboard@viewCategory');
Route::get('admin/menu','newdashboard@index');
Route::get('admin/viewcategory/{id}','newdashboard@viewCategory');
Route::post('admin/addcategory/{id}','newdashboard@createCategory');
Route::get('admin/deletecategory/{id}','newdashboard@deleteCategory');
Route::get('admin/addmenuitem/{id}','newdashboard@MenuItem');
Route::post('admin/addmenuitem','newdashboard@createMenuItem');
Route::get('admin/viewmenuitem/{id}','newdashboard@viewMenuItem');
Route::get('admin/deletemenuitem/{id}','newdashboard@deleteMenuItem');
Route::get('admin/editmenuitem/{id}','newdashboard@editMenuItem');
Route::post('admin/editmenuitem/{id}','newdashboard@doEditMenuItem');
//search routes
Route::get('admin/search', 'newdashboard@searchCustomer');
Route::post('admin/search', 'newdashboard@doSearchCustomer');
Route::get('admin/search/restaurant', 'newdashboard@doSearchRestuarant');
Route::get('admin/search/customer', 'newdashboard@doSearchCustomer');
Route::get('admin/search/orderinfo', 'newdashboard@doSearchOrderInfo');

});

Route::group(['middleware' => 'restMiddleware'], function () {
//restaurant

Route::get('restaurant/index','restdashboard@index');
Route::get('restaurant/vieworderdetail/{id}','restdashboard@viewOrderDetail');
Route::post('restaurant/editorderdetail/{id}','restdashboard@editOrderDetail');
Route::get('restaurant/vieworder','restdashboard@viewOrder');
Route::get('restaurant/deleteorder','restdashboard@deleteOrder');

Route::get('restaurant/index12','restdashboard@index12');
Route::post('restaurant/edit','restdashboard@edit');
Route::get('restaurant/viewprofile','restdashboard@viewProfile');
Route::post('restaurant/edit','restdashboard@edit');

Route::get('restaurant/viewmenuitem','restdashboard@viewMenuItem');
Route::get('restaurant/addmenuitem','restdashboard@MenuItem');
Route::post('restaurant/addmenuitem','restdashboard@createMenuItem');
//Route::get('restaurant/deletemenuitem','restdashboard@deleteMenuItem');
Route::get('restaurant/editmenuitem/{id}','restdashboard@editMenuItem');
Route::get('restaurant/deletemenuitem/{id}','restdashboard@deleteMenuItem');
Route::post('restaurant/editmenuitem/{id}','restdashboard@doEditMenuItem');
Route::post('restaurant/editmenuitem','restdashboard@editMenuItem');
Route::get('restaurant/vieworder','resdashboard@viewOrder');
Route::get('restaurant/deleteorder','resdashboard@deleteOrder');
Route::get('restaurant/viewmenusubitem/{id}','restdashboard@viewMenuWithSubItem');
Route::get('restaurant/viewsubitem/{id}','restdashboard@viewSubItem');
Route::post('restaurant/viewsubitem/{id}','restdashboard@editSubItem');


Route::get('restaurant/viewcategory','restdashboard@viewCategory');
Route::post('restaurant/addcategory','restdashboard@createCategory');
Route::get('restaurant/deletecategory/{id}','restdashboard@deleteCategory');


//View Sale Report

Route::get('restaurant/salereport','restdashboard@SaleReport');
Route::get('restaurant/viewsalereport','restdashboard@ViewSaleReport');

// Update Availibility
Route::get('restaurant/updateavailibility','restdashboard@updateAvailibility');
});

Route::group(['middleware' => 'custMiddleware'], function () {
//customer
Route::get('customer/index','customer@index');
Route::post('customer/placeorder','customer@placeOrder');
Route::get('custmer/deleteorder','customer@deleteOrder');
Route::post('customer/edit','customer@edit');

});
