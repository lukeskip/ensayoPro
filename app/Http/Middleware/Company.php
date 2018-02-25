<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth as Auth;

use Closure;

class Company
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

        $user    = Auth::user();
        $role    = $user->roles->first()->name;
        $company = $user->companies->first();
        if($role == 'company' or $role == 'admin'){
          

            return $next($request);
            
        }else if($role == 'musician'){
           return redirect('/musico/bienvenido'); 
        }
        
        
    }
}
