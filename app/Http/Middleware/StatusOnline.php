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
    public function handle(Request $request, Closure $next): Response
    {
        $user_id = Auth::user()->user_id;
        User::where('user_id', $user_id)->update(['last_activity' => now()]);

        $log_login_date = LogStatus::select('id', 'login_date')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

        if ($log_login_date) {
            $log_login_date->last_activity = now();
            $log_login_date->save();
        }

        return $next($request);
    }
}
