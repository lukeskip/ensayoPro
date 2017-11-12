<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth as Auth;

use Closure;

class Admin
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
        $role = Auth::user()->roles->first()->name;

        if($role == 'admin'){
            return $next($request);
        }else if($role == 'company'){
           return redirect('company'); 
        }else if($role == 'musician'){
           return redirect('/dashboard'); 
        }
    }
}
