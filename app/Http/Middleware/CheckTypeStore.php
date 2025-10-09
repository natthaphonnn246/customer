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

class CheckTypeStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        date_default_timezone_set('Asia/Bangkok');

        if (Auth::check()) {
            $user = Auth::user();
    
            // ดึงข้อมูลล่าสุดของผู้ใช้
            $user_checked = ProductType::where('user_id', $user->user_id)
                            ->latest('id')
                            ->first();
                
            if (!$user_checked) {
                return redirect()->route('portal.product-type');
            }
    
            if ($user_checked->checked === 1) {
    
                $log_login_date = ProductType::where('user_id', $user->user_id)
                    ->latest('id')
                    ->first();
    
                if (!$log_login_date || !$log_login_date->last_activity) {
                    return redirect()->route('portal.product-type');
                }
    
                // แปลง last_activity เป็น timestamp (ถ้าเก็บ datetime)
                $lastActiveTimestamp = strtotime($log_login_date->last_activity);

                // กำหนดเวลาเข้าใช้งาน
                $setting_timer = Setting::where('setting_id', 'WS01')->first();
                $check_type_time = $setting_timer?->check_time_type ?? 300;
                
    
                // เช็คว่าเกิน 300 วินาทีหรือไม่
                if ((time() - $lastActiveTimestamp) > $check_type_time) {
                    return redirect()->route('portal.product-type');
                }
    
                // อัปเดต last_activity
      /*           ProductType::where('user_id', $user->user_id)
                            ->latest('id')
                            ->first()
                            ->update(['last_activity' => now()]); */

                    tap(
                        ProductType::where('user_id', $user->user_id)
                            ->latest('id')
                            ->first()
                    )?->update(['last_activity' => now()]);
                
                            
    
            } else {
                return redirect()->route('portal.product-type');
            }
        }
    
        return $next($request);
    }
    
}