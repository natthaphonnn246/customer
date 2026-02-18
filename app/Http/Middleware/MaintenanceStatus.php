<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
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
        $setting = Setting::where('setting_id', 'WS01')->first();

        if ($setting->web_status === "1") {
            if ($setting->allowed_web_status === '1') {
                if (Auth::user()->allowed_user_status === '0') {
                    return $this->logoutAndRedirect($request);
                }

                return $next($request);
            }

            return $this->logoutAndRedirect($request);
        }

        return $next($request);
    }

    private function logoutAndRedirect(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('maintain_active', 'ปิดปรับปรุงระบบ');
    }
}
