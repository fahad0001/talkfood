<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\User;
use App\PasswordReset;

use Illuminate\Support\Facades\Mail;

class users extends Controller {

    public function resetPassword($id) {
        $user = User::where('id', $id)->first();
        return view('admin.reset_password', compact('id', 'user'));
    }

    public function doResetPassword(Request $request, $id) {
        $user = User::where('id', $id);
        if(Input::get('password') == Input::get('confirm_password')) {
            $user->update([
                'password' => bcrypt(Input::get('password'))
            ]);
            return Redirect::to('admin/viewcustomer');
        } else {
            $request->session()->flash('status', 'Password didn\'t match!');
        }
        $user = $user->first();
        return view('admin.reset_password', compact('id', 'user'));
    }

    public function forgotPassword() {
        return view('forgot_password');
    }

    public function doForgotPassword(Request $request) {
        $user = User::where('email', Input::get('email'))->first();
        if(!empty($user)) {
            $token = uniqid();
            $data = ['token' => $token, 
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'created_at' => date('Y-m-d H:i:s')];

            PasswordReset::create($data);
            
            Mail::send('emails.forgot_password', $data, function ($message) use ($data) {
                $message->subject("Forgot Password");
                $message->to($data['email']);
            });

            $request->session()->flash('success', 'Password reset has been sent to email');
        
            return Redirect::to('login');
        } else {
            $request->session()->flash('status', 'Email doesn\'t exist!');
        }
        return view('forgot_password');
    }

    public function resetForgotPassword(Request $request, $token) {
        $user = PasswordReset::where([['token', '=', $token],['created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 days'))]])->first();
        if(empty($user)) {
            $request->session()->flash('status', 'Invalid Link!');
            return Redirect::to('login');
        } else {
        
        }
        return view('reset_password', compact('user', 'token'));
    }

    public function doResetForgotPassword(Request $request, $token) {
        $user = User::where('email', Input::get('email'));
        if(Input::get('password') == Input::get('confirm_password')) {
            $user->update([
                'password' => bcrypt(Input::get('password'))
            ]);
            $request->session()->flash('success', 'Password reset successfully!');
            return Redirect::to('login');
        } else {
            $request->session()->flash('status', 'Password didn\'t match!');
        }
        $user = $user->first();
        return view('reset_password', compact('user', 'token'));
    }
}