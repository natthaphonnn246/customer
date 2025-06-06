<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RightsArea
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->admin_role === 1) {
            if(Auth::user()->rights_area === 0) {

                return redirect('/signin');

            } 
            return $next($request);
        }

        if(Auth::user()->rights_area === 0) {

            return redirect('/signin');

        } 
        return $next($request);
            
    }
}
