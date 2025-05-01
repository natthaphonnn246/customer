<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Auth;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //test;
        if(Auth::user()->admin_role === 1) {

            if(Auth::user()->user_id == '0000' || Auth::user()->user_id == '4494' || Auth::user()->user_id == '9000') {

                return $next($request);

            } else {
                 // return logout;
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');
            }
            
        }

        if (Auth::user()->role === 2) 
        {

            // return $next($request);

            if(Auth::user()->user_id == '0000' || Auth::user()->user_id == '4494' || Auth::user()->user_id == '9000') {
                
                return $next($request);

            } else {
                 // return logout;
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');
            }
            
        } else {

            // return logout;
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');
        }

      /*   Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล'); */
        
       /*  if (Auth::user()->role == 2) 
        {

            return $next($request);
        }
        else {
            // return back();

            // return logout;
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');
        } */
    }
}
