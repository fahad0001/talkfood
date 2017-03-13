<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class adminMiddleware
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
             if($userRole==='admin')
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
