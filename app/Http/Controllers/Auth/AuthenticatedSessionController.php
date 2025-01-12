<?php

namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
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
    
        if (Auth::attempt($credentials))
        {
            
                if(Auth::user()->user_id == '0000') {
                    return redirect()->route('webpanel');
                    
                }

                if(Auth::user()->maintenance_status == '1') 
                {

                            if(Auth::user()->allowed_maintenance_status == '1') 
                            {

                                if(Auth::user()->allowed_user_status == '0') {
                                    // return logout;
                                    Auth::guard('web')->logout();
                                    $request->session()->invalidate();
                                    $request->session()->regenerateToken();
                                    return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');

                                } else {

                                        if(Auth::user()->rights_area == '1')
                                        {
            
                                                $admin_check = $request->user()->admin_area;
                                    
                                                $user = Customer::select('admin_area')->where('admin_area', $admin_check)->first();
                                                // $admin_area = $user->admin_area;
                                                // dd($user);

                                                //check admin area between customers and users;
                                                if($user != null)
                                                {
                                                    $admin_area = $user->admin_area;

                                                    if(Auth::user()->role == '1')
                                                    {
                                                        $request->authenticate();
                                                        $request->session()->regenerate();
                                                        return redirect()->route('webpanel');
                                            
                                                    } else {
                                        
                                                        if(Auth::user()->admin_area ==  $admin_area) {

                                                        $request->authenticate();
                                                        $request->session()->regenerate();
                                                        // return redirect()->route('portal');
                                                        return redirect()->action(
                                                            [CustomerController::class, 'customerView']
                                                        );

                                                        } else {

                                                            return back();
                                                        }

                                                    }
                                                    
                                                } else {

                                                    return redirect()->route('portal');
                                                }
                            
                                        } else {
                                            
                                            return redirect()->route('portal.sign');
                                        } 

                                    }
                            
                            } else {

                                    if(Auth::user()->rights_area == '1')
                                    {
                                
                                            $admin_check = $request->user()->admin_area;
                                
                                            $user = Customer::select('admin_area')->where('admin_area', $admin_check)->first();
                                            // $admin_area = $user->admin_area;
                                            // dd($user);

                                            //check admin area between customers and users;
                                            if($user != null)
                                            {
                                                $admin_area = $user->admin_area;

                                                if(Auth::user()->role == '1')
                                                {
                                                    $request->authenticate();
                                                    $request->session()->regenerate();
                                                    return redirect()->route('webpanel');
                                        
                                                } else {
                                    
                                                    if(Auth::user()->admin_area ==  $admin_area) {

                                                    $request->authenticate();
                                                    $request->session()->regenerate();
                                                    // return redirect()->route('portal');
                                                    return redirect()->action(
                                                        [CustomerController::class, 'customerView']
                                                    );

                                                    } else {

                                                        return back();
                                                    }

                                                }
                                                
                                            } else {
                                                
                                                return redirect()->route('portal');
                                            }
                        
                                    } else {
                                        
                                        return redirect()->route('portal.sign');
                                    } 

                                }

                } else {

                            if(Auth::user()->rights_area == '1') {
                        
                                    $admin_check = $request->user()->admin_area;
                        
                                    $user = Customer::select('admin_area')->where('admin_area', $admin_check)->first();
                                    // $admin_area = $user->admin_area;
                                    // dd($user);

                                    //check admin area between customers and users;
                                    if($user != null)
                                    {
                                        $admin_area = $user->admin_area;

                                        if(Auth::user()->role == '1')
                                        {
                                            $request->authenticate();
                                            $request->session()->regenerate();
                                            return redirect()->route('webpanel');
                                
                                        } else {
                            
                                            if(Auth::user()->admin_area ==  $admin_area) {

                                            $request->authenticate();
                                            $request->session()->regenerate();
                                            // return redirect()->route('portal');
                                            return redirect()->action(
                                                [CustomerController::class, 'customerView']
                                            );

                                            } else {

                                                return back();
                                            }

                                        }
                                        
                                    } else {

                                        return redirect()->route('portal');

                                    }
                
                            } else {
                                
                                return redirect()->route('portal.sign');
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
