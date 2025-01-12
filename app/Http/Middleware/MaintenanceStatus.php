<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->maintenance_status == '1') 
        {

            if(Auth::user()->allowed_maintenance_status == '1') {

                if(Auth::user()->allowed_user_status == '0') {
                    // return logout;
                    Auth::guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');

                } else {

                    return $next($request);
                }
               
            }
            // return $next($request);
            // return logout;
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');

        }

        return $next($request);


            // return logout;
            /* Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล'); */
        
        
    }
}
