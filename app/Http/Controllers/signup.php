<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Restaurant;
use App\Customer;
use App\CustomerAddress;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Socialite;

class signup extends Controller {

    public function signup() {

        // if(Auth::check())
        //{  
        //}
        if(Input::has('returnurl')) {
            $returnurl=1;
            return view('registration',compact("returnurl"));
        }
        else {
        return view('registration');
        }
    }

    public function doSignUp() {
        $type = Input::get('account');

         //return var_dump(Input::all());

        if ($type === 'cus') {
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
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
                'con_pass' => 'min:6|same:password'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->passes()) {
                    
             //  return var_dump(Input::all());
                $firstName = Input::get('firstname');
                $lastName = Input::get('lastname');
                $provider_name = Input::get('provider_name');
                $provider_id = Input::get('provider_id');

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
                $password = Input::get('password');

                $user = User::create([
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                           
                            'email' => $emailNo,
                            'password' => bcrypt($password),
                              'role'=>$type,
                              
                            'provider'=>$provider_name,
                            'provider_id'=>$provider_id,
                ]);
                
               
                $ship_adress = CustomerAddress::create([
                            'street' => $cusShipStreet,
                            'city' => $cusShipCity,
                            'country' => $cusShipCountry,
                            'zip_code' => $cusShipZipCode,
                            'state_province' => $cusShipState,
                            'phone_no' => $cusShipPhoneNo,
                            'cus_id' => $user->id,
                            'address_type' => 'ship',
                ]);
                
                
                  $del_adress= CustomerAddress::create([
                            'street' => $cusShipStreet,
                            'city' => $cusShipCity,
                            'country' => $cusShipCountry,
                            'zip_code' => $cusShipZipCode,
                            'state_province' => $cusShipState,
                            'phone_no' => $cusShipPhoneNo,
                            'cus_id' => $user->id,
                            'address_type' => 'del',
                ]);
                
                $bill_adress = CustomerAddress::create([
                            'street' => $cusBillStreet,
                            'city' => $cusBillCity,
                            'country' => $cusBillCountry,
                            'zip_code' => $cusBillZipCode,
                            'state_province' => $cusBillState,
                            'phone_no' => $cusBillPhoneNo,
                            'cus_id' => $user->id,
                            'address_type' => 'bill',
                ]);
                if(Input::has('returnurl')) {
                    if(Input::get('returnurl')=="checkout") {
                        Auth::attempt(['email'=>$emailNo,'password'=>$password]);
                         return Redirect::to('cart');
                    }
                    else {
                         return Redirect::to('signup')->with('message','Successfully Signedup!');
                    }
                }
                else {
                     return Redirect::to('signup')->with('message','Successfully Signedup!');
                }
              
           
            } else {
                return Redirect::to('signup')->with('emessage', 'The following errors occurred')->withErrors($validator);
            }
        } else {
            $rules = array(
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'rest_name' => 'required|max:255',
                'kitchen_type' => 'required|max:255',
                'rest_street' => 'required|max:255',
                'rest_city' => 'required|max:255',
                'rest_state' => 'required|max:255',
                'rest_country' => 'required|max:255',
                'rest_zip' => 'required|max:255',
                'rest_phoneno' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
                'con_pass' => 'same:password',
                'rest_logo'=> 'required'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->passes()) {

                $firstName = Input::get('firstname');
                $lastName = Input::get('lastname');
                $provider_name = Input::get('provider_name');
                $provider_id = Input::get('provider_id');

                $restuarantName = Input::get('rest_name');
                $kitchenType = Input::get('kitchen_type');
                $street = Input::get('rest_street');
                $city = Input::get('rest_city');
                $state = Input::get('rest_state');
                $country = Input::get('rest_country');
                $zipCode = Input::get('rest_zip');
                $phoneNo = Input::get('rest_phoneno');
                $emailNo = Input::get('email');
                $password = Input::get('password');
				
				$loc=app('geocoder')->using('chain')->geocode($street.','.$city.','.$zipCode.','.$country)->all();
				$lat=$loc[0]->getCoordinates()->getLatitude();
				$lng=$loc[0]->getCoordinates()->getLongitude();
				
                if (Input::file('rest_logo')) {
                    $destinationPath = 'uploads'; // upload path
                    $imageName = Input::file('rest_logo')->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $imageName; // renameing image
                    Input::file('rest_logo')->move($destinationPath, $fileName); // uploading file to given path    
                }

				
                $user = User::create([
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'email' => $emailNo,
                            'password' => bcrypt($password),
                            'role'=>'rest',
                            'provider'=>$provider_name,
                            'provider_id'=>$provider_id,
                ]);
                Restaurant::create([
                    
                    'rest_name' => $restuarantName,
                    'rest_user_id' => $user->id,
                    'kitchen_type' => $kitchenType,
                    'rest_street' => $street,
                    'rest_city' => $city,
                    'rest_country' => $country,
                    'rest_postal_code' => $zipCode,
                    'rest_status' => 'pending',
                    'rest_state_province' => $state,
                    'rest_logo_path' => $fileName,
                    'rest_phone_no' => $phoneNo,
					'rest_lat' =>$lat,
					'rest_long'=>$lng
                ]);
               return Redirect::to('signup')->with('message','Successfully Signedup!');
            } else {
                return Redirect::to('signup')->with('emessage', 'The following errors occurred')->withErrors($validator);
            }
        };
    }
    
    public function signout() {
        Auth::logout();
        return redirect('/');
    }

}
