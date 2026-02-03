<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/signin');
        }
    
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'ไม่มีสิทธิ์ตาม role');
        }
    
        return $next($request);
    }
    
}
