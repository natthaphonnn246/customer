<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use App\Models\ProductType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckMenuAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $check_type_pass = 0;
        $code_pass = 0;

        $setting_check = Setting::where('setting_id', 'WS01')->value('check_type');

        if (Auth::check()) {
            $user = Auth::user();
            $code_type = User::where('user_id', $user->user_id)->value('allowed_check_type');

            if ((int)$setting_check === 1) {
                if ((int)$code_type === 1) {
                    $check_type_pass = 1;
                    $code_pass = 1;
                }
            } else {

                $check_type_pass = 1;
                $code_pass = 1;
            }
        }

        view()->share('check_type_pass', $check_type_pass);
        view()->share('code_pass', $code_pass);

        return $next($request);
    }
}
