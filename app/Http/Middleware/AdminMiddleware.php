<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            // admin role == 1
            // user role == 0
            if(Auth::user()){
                 return $next($request);
            }else{
                // dd($request);
                // return redirect('/')->with('message','access denied as you are not admin ! ');
               return response()->json('access denied as you are not admin ! ');
            
            }
        }else {
            // dd($request);
            return response()->json('you need to login to access in user info ! ');
            
        }
        return $next($request);
    }
}
