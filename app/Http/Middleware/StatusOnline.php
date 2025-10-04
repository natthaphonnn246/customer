<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\LogStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StatusOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /* public function handle(Request $request, Closure $next): Response
    {
        $user_id = Auth::user()->user_id;
        User::where('user_id', $user_id)->update(['last_activity' => now()]);

        $log_login_date = LogStatus::select('id', 'login_date')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

        if ($log_login_date) {
            $log_login_date->last_activity = now();
            $log_login_date->save();
        }

        return $next($request);
    } */

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // อัปเดต last_activity ของ user
            User::where('user_id', $user->user_id)
                ->update(['last_activity' => now()]);

            // อัปเดต last_activity ของ LogStatus ล่าสุด
            $log_login_date = LogStatus::where('user_id', $user->user_id)
                ->latest('id')
                ->first();

            if ($log_login_date) {
                $log_login_date->last_activity = now();
                $log_login_date->save();
            }
        }

        return $next($request);
    }
}
