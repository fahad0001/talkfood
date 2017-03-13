<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class restMiddleware
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
             if($userRole==='rest')
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
