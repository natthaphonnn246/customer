<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            ]);
    
        if (Auth::attempt($credentials)) {

            if(Auth::user()->user_id == '0000') {
                return redirect()->route('webpanel');
                
            } else {
            $admin_check = $request->user()->admin_area;
            $user = DB::table('customers')->select('admin_area')->where('admin_area', $admin_check)->get();
            $admin_area = $user[0]->admin_area;
    
            if(Auth::user()->role == '1')
            {
                $request->authenticate();
                $request->session()->regenerate();
                return redirect()->route('webpanel');
    
            } else {
 
                if(Auth::user()->admin_area ==  $admin_area)
                {
               
                    $request->authenticate();
                    $request->session()->regenerate();
                    // return redirect()->route('portal');
                    return redirect()->action(
                        [UserController::class, 'portalSignin']
                    );

                } else {

                    return back();
                }

            }
        }
            
        } else {
            
            $request->authenticate();

            $request->session()->regenerate();

            return redirect()->intended(route('/', absolute: false));
        }
        
        /* $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false)); */
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function destroyPortal(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
