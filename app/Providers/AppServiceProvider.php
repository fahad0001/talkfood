<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
            \URL::forceSchema('https');

      
        View::composer('*', function($view){
            if(Auth::check()) {
            $r=  \App\Restaurant::where('rest_user_id',\Auth::user()->id)->first();
        $view->with(['currentUser'=> \Auth::user(),'rest'=>$r]);
            }
    });
    
      
        
    
       
   
    
    
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
