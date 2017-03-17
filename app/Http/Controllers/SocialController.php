<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Support\Facades\Input;
use App\User;
use Auth;
use Illuminate\Support\Facades\Redirect;

class SocialController extends Controller
{
    //facebook
    public function redirectToProvider(){
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderCallback(){
        $user = Socialite::driver('facebook')->user();
        $splitName = explode(' ', $user->getName(), 2);
        $firstname = $splitName[0];
        $lastname = !empty($splitName[1]) ? $splitName[1] : '';
        $provider_id=$user->getId();
        $provider_name="facebook";
        $email=$user->getEmail();
        $checkuser=$this->checkLogin($provider_name ,$provider_id);
        if($checkuser!=null){
            $userRole= Auth::user()->role;
            if($userRole==='admin')
            {
               return Redirect::to('admin/index'); 
            }
            else if($userRole==='cus') {
                return Redirect::to('/'); 
            }
            else 
                return Redirect::to('restaurant/index'); 
        }
        
        else return view('registration',compact('firstname','lastname','proivder_id','email','provider_name'));

    }

        //google
    public function googleRedirectToProvider(){
        return Socialite::driver('google')->redirect();
    }
    public function googleHandleProviderCallback(){
        $user = Socialite::driver('google')->user();
        $splitName = explode(' ', $user->getName(), 2);
        $firstname = $splitName[0];
        $lastname = !empty($splitName[1]) ? $splitName[1] : '';
        $provider_id=$user->getId();
        $provider_name="google";
        $email=$user->getEmail();
        $checkuser=$this->checkLogin($provider_name ,$provider_id);
        if($checkuser!=null){
            $userRole= Auth::user()->role;
            if($userRole==='admin')
            {
               return Redirect::to('admin/index'); 
            }
            else if($userRole==='cus') {
                return Redirect::to('/'); 
            }
            else 
                return Redirect::to('restaurant/index'); 
        }
        
        else return view('registration',compact('firstname','lastname','proivder_id','email','provider_name'));

    }


//linkedin
    public function linkedinRedirectToProvider(){
        return Socialite::driver('linkedin')->redirect();
    }
    public function linkedinHandleProviderCallback(){
        $user = Socialite::driver('linkedin')->user();
        $splitName = explode(' ', $user->getName(), 2);
        $firstname = $splitName[0];
        $lastname = !empty($splitName[1]) ? $splitName[1] : '';
        $provider_id=$user->getId();
        $provider_name="linkedin";
        $email=$user->getEmail();
        $checkuser=$this->checkLogin($provider_name ,$provider_id);
        if($checkuser!=null){
            $userRole= Auth::user()->role;
            if($userRole==='admin')
            {
               return Redirect::to('admin/index'); 
            }
            else if($userRole==='cus') {
                return Redirect::to('/'); 
            }
            else 
                return Redirect::to('restaurant/index'); 
        }
        
        else return view('registration',compact('firstname','lastname','proivder_id','email','provider_name'));

    }



    //twitter
    public function twitterRedirectToProvider(){
        return Socialite::driver('twitter')->redirect();
    }
    public function twitterHandleProviderCallback(){
        $user = Socialite::driver('twitter')->user();
        $splitName = explode(' ', $user->getName(), 2);
        $firstname = $splitName[0];
        $lastname = !empty($splitName[1]) ? $splitName[1] : '';
        $provider_id=$user->getId();
        $provider_name="twitter";
        $email=$user->getEmail();
        $checkuser=$this->checkLogin($provider_name ,$provider_id);
        if($checkuser!=null){
            $userRole= Auth::user()->role;
            if($userRole==='admin')
            {
               return Redirect::to('admin/index'); 
            }
            else if($userRole==='cus') {
                return Redirect::to('/'); 
            }
            else 
                return Redirect::to('restaurant/index'); 
        }
        
        else return view('registration',compact('firstname','lastname','proivder_id','email','provider_name'));

    }
    public function checkLogin($provider_name ,$provider_id){
        $user=User::where('provider',$provider_name)
                    ->where('provider_id',$provider_id)
                    ->first();
        if($user!=null){
            Auth::loginUsingId($user->id);
        }
        return $user;
    }

}
