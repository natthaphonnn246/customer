<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RightAreaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('portal.sign');
        }

        if (Auth::user()->rights_area !== 1) {
            // abort(403, 'ไม่มีสิทธิ์เข้าพื้นที่นี้');
            return $next($request);
        }

        return $next($request);
    }

}
