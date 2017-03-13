<?php

namespace App\Http\Middleware;

use Closure;
use App\oauth;
class tokenauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(!isset($_SERVER['HTTP_TOKEN'])){  
            
            return array('error'=>'User not allowed');  
        }  
  
         
       if (!oauth::where('token', '=',$_SERVER['HTTP_TOKEN'])->exists()) {
            return array('error'=>'Invalid Token');  
        }  
        return $next($request);
    }
}
