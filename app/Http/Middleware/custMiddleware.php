<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class custMiddleware
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
       if(Auth::check()) {
           $userRole= Auth::user()->role;
             if($userRole==='cus')
            {
                return $next($request);
            }
            else {
                return redirect('/');
            }  
        }
        else {
            return redirect('/');
        }
    }
}
