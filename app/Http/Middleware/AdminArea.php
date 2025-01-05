<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminArea
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

        public function handle(Request $request, Closure $next): Response
        {
            $admin_check = $request->user()->admin_area;
            $user = DB::table('customers')->select('admin_area')->where('admin_area', $admin_check)->first();
            $admin_area = $user->admin_area;
    
            if(!Auth::user()->admin_area == $admin_area)
            {
                return back();
                
            }
            return $next($request);
        }
    
}
