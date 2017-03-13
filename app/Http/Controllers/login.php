<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class login extends Controller
{
    public function login() {
        
        if(Auth::check())
        {  
            $userRole= Auth::user()->role;
             if($userRole==='admin')
            {
               return Redirect::to('admin/index'); 
            }
            else if($userRole==='cus') {
                return Redirect::to('/'); 
            }
            else {
                return Redirect::to('restaurant/index'); 
            }
           
            
        }
        else {
           
             return view('login');
        }
       
    }
    public function dologin() {
        $rules = array(
                'email' => 'required|email|max:255',
                'password' => 'required|min:6|', 
                );
        $validator = Validator::make(Input::all(),$rules);
        if ($validator->passes()) {
            if(Auth::attempt(['email'=>Input::get('email'),'password'=>Input::get('password')]))
        {
           $userRole= Auth::user()->role;
            if($userRole==='admin')
            {
               return Redirect::to('admin/index'); 
            }
            else if($userRole==='cus') {
                return Redirect::to('/'); 
            }
            else {
                return Redirect::to('restaurant/index'); 
               
            }
           
        }
        else {
             return Redirect::to('login'); 
        }
        }
        else{
            return Redirect::to('login')->with('emessage', 'The following errors occurred')->withErrors($validator);
      
        }
        
    }
}
