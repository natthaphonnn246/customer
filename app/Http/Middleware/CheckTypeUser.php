<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTypeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting_check = Setting::where('setting_id', 'WS01')->value('check_type');

        if ((int)$setting_check === 1) {

            if (Auth::check()) 
            {
                $user = Auth::user();
                $data_user = User::where('user_id', $user->user_id)->first();

                if ($data_user && (int)$data_user->allowed_check_type === 1) {
                    return $next($request);
                }

                Auth::logout();
                return redirect()->route('login')->with('error_purchase', 'คุณไม่มีสิทธิ์เข้าถึง');
            }
        }


        return $next($request);
    }

}
