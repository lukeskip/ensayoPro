<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth as Auth;

use Closure;

class Active
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
        $active = Auth::user()->active;
        if($active){
            return $next($request);
        }else{
            return redirect('/activa_tu_cuenta');
        }
        
       
    }
}
