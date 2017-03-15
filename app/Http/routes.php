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
Route::get('signup','signup@signup');
Route::get('logout','signup@signout');
Route::post('signup/store','signup@doSignUp');

//login
Route::get('login','login@login');
Route::post('login','login@dologin');

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

 Route::get('admin/allorders', 'dashboard@viewallorders');
   Route::get('admin/viewallorderdetails/{id}', 'dashboard@viewallOrderDetails');
    Route::get('admin/viewallorderdetails/delete/{id}', 'dashboard@viewallOrderdelete');
// New Added Functions
// Update Availibility Status of All Resturants
Route::get('admin/updateavailibility/{status}','newdashboard@updateAvailibility');
});
Route::get('search/autocomplete', 'newdashboard@autocomplete');
Route::get('search/', function(){
    return view('admin.search');
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
