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

        date_default_timezone_set("Asia/Bangkok");
        $minutes_to_add = 5;
        // $date = time() + ($minutes_to_add * 60); // Add 15 minutes in seconds
        $date = time();
   

        $user_id = Auth::user()->user_id;
        User::where('user_id', $user_id)
                ->update([
                    // 'date_login'=> date("h:i:s"),
                    'last_activity'=> $date,
                            ]);
                    $log_login_date = LogStatus::select('id','login_date')->where('user_id', $user_id)->orderBy('id', 'desc')->first();
                    // dd($log_login_date->id);


                    if(($log_login_date->id) != '') {
                    LogStatus::where('id', $log_login_date->id)
                                        ->update([
                                            // 'date_login'=> date("h:i:s"),
                                        'last_activity'=> $date,
                            ]);
                }




            return $next($request);
        
    
    }
}
