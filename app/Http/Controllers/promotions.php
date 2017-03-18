<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\PromotionSetting;
use App\Promotion;
use App\User;

use Illuminate\Support\Facades\Mail;


class promotions extends Controller
{
    public function index()
    {
        $promotionSettings=PromotionSetting::all();
        return view('admin.promotions',compact('promotionSettings'));
    }

    public function editSetting($id){    

        $promotionSetting=PromotionSetting::find($id);
        return view('admin.editPromotionSetting',compact('promotionSetting'));
    }
    public function changeSetting($id){
        $status = Input::get('status') ? true : false;
        $expiry = (int)Input::get('expiry');
        $promotionSetting=PromotionSetting::updateOrCreate(
            ['id' => $id],
            ['status' => $status]
        );
        $promotionSetting=PromotionSetting::updateOrCreate(
            ['id' => $id],
            ['expiry' => $expiry]
        );
                
        return Redirect('/admin/promotions');
    }
    
    public function addPromotion(){

        $code = uniqid();
        $promotion=Promotion::create([
            'user_id' => Input::get('user_id'),
            'promotion_setting_id' => (int)Input::get('promotion_setting_id'),
            'code' => $code
        ]);

        $promotionSetting = PromotionSetting::find((int)Input::get('promotion_setting_id'));
        $user = User::find((int)Input::get('user_id'));

        $data = ['code' => $code, 
            'usage' => $promotionSetting->usage, 
            'name' => $user->first_name . ' ' . $user->last_name, 
            'expiry' => date('m/d/Y', strtotime('+'. $promotionSetting->expiry . 'days')),
            'email' => $user->email
        ];
        Mail::send('emails.promotion', $data, function ($message) use ($data) {
            $message->subject("Promotion Code Access");
            $message->to($data['email']);
            $message->cc('info@talkfood.org');
        });

        return Redirect('/admin/viewCustomerAddress/' . Input::get('user_id'));
    }

    public function deletePromotion($id){

        $promotion=Promotion::find($id);
        $promotion->delete();
                
        return Redirect('/admin/viewCustomerAddress/' . $promotion->user_id);
    }
}