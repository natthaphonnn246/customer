<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerDetailCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $check_edit = DB::table('settings')->where('setting_id', '=', 'WS01')->first()?->check_edit;
        // return $next($request);

        $id = $request->route('id'); 

        // $check_status = Customer::where('id', $id)->first()->customer_status;
        $check_status = Customer::where('slug', $id)->first()->customer_status;

        if($check_edit === 1) {

            Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error_check', 'กรุณาติดต่อผู้ดูแล');
        }


        if($check_status === 'inactive') {
            
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error_check', 'กรุณาติดต่อผู้ดูแล');

        }
        
        return $next($request);
    }
}
