<?php

namespace App\Http\Controllers\Auth;

use App\Models\Setting;
use App\Models\User;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Portal\PortalCustomerController;
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
        return view('auth.login-tailwind');
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
        
        $check_email_rights = $request->email;
        // dd($check_email_rights);
    
        if (Auth::attempt($credentials))
        {
            
                //superadmin;
                if(Auth::user()->user_id == '0000') {
                    return redirect('webpanel');
                    
                }

                // if(Auth::user()->maintenance_status == '1')
                $web_status = Setting::where('setting_id', 'WS01')->first();
                if($web_status->web_status == '1')  
                {
                            // if(Auth::user()->allowed_maintenance_status == '1') 
                            $allowed_web_status = Setting::where('setting_id', 'WS01')->first();
                            if($allowed_web_status->allowed_web_status == '1') 
                            {

                                if(Auth::user()->allowed_user_status == '0') {
                                    // return logout;
                                    Auth::guard('web')->logout();
                                    $request->session()->invalidate();
                                    $request->session()->regenerateToken();
                                    return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');

                                } else {

                                    //check amdin_area at table: customers if null redirect to logout;
                                    $check_admin_area = $request->user()->admin_area;
                                    $check_admin_customer = Customer::where('admin_area', $check_admin_area)->first();
                                    // dd($check_admin_customer);
                                    if($check_admin_customer != null) 
                                    {
                                        // dd('Please select');
                                    
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

                                                 /*    if(Auth::user()->role == '1')
                                                    {
                                                        $request->authenticate();
                                                        $request->session()->regenerate();
                                                        return redirect()->route('webpanel');
                                            
                                                    } else { */
                                        
                                                        if(Auth::user()->admin_area ==  $admin_area) {

                                                        $request->authenticate();
                                                        $request->session()->regenerate();
                                                        // return redirect()->route('portal');
                                                        return redirect()->action(
                                                            // [PortalCustomerController::class, 'customerView']
                                                            [PortalCustomerController::class, 'dashboardCharts']
                                                        );

                                                        } else {

                                                            return back();
                                                        }

                                                    // }
                                                    
                                                } else {

                                                  /*   //check rights_area;
                                                    $check_rights_area = User::select('rights_area')->where('email',  $check_email_rights)->first();
                                                    // dd(($check_rights_area->rights_area));
                                                    if($check_rights_area->rights_area == 0) {
                                                        return back();

                                                    } */
                                                    return redirect()->route('portal');
                                                }
                                        //admin;
                                        } elseif (Auth::user()->role == '1') {
                                            
                                            // return redirect()->route('portal.sign');
                                            return redirect()->route('webpanel.report');
                                        
                                        } else {
                                            return redirect()->route('portal.sign');

                                        }
                                    } else {
                                        // not admin_area at table customes;
                                        Auth::guard('web')->logout();
                                        $request->session()->invalidate();
                                        $request->session()->regenerateToken();
                                        return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');
                                    }

                                }
                            
                            } else {

                                //check amdin_area at table: customers if null redirect to logout;
                                $check_admin_area = $request->user()->admin_area;
                                $check_admin_customer = Customer::where('admin_area', $check_admin_area)->first();
                                // dd($check_admin_customer);
                                if($check_admin_customer != null) 
                                {


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


                                              /*   if(Auth::user()->role == '1')
                                                {
                                                    $request->authenticate();
                                                    $request->session()->regenerate();
                                                    return redirect()->route('webpanel');
                                        
                                                } else { */
                                    
                                                    if(Auth::user()->admin_area ==  $admin_area) {

                                                    $request->authenticate();
                                                    $request->session()->regenerate();
                                                    // return redirect()->route('portal');
                                                    return redirect()->action(
                                                        // [PortalCustomerController::class, 'customerView']
                                                        [PortalCustomerController::class, 'dashboardCharts']
                                                    );

                                                    } else {

                                                        return back();
                                                    }

                                                // }
                                                
                                            } else {
                                                
                                                return redirect()->route('portal');
                                            }
                        
                                    } elseif (Auth::user()->role == '1') {
                                            
                                        // return redirect()->route('portal.sign');
                                        return redirect()->route('webpanel.report');
                                    
                                    } else {
                                        return redirect()->route('portal.sign');

                                    } 
                                } else {
                                    // not admin_area at table customes;
                                    Auth::guard('web')->logout();
                                    $request->session()->invalidate();
                                    $request->session()->regenerateToken();
                                    return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');
                                }

                            }

                } else {

                        //check amdin_area at table: customers if null redirect to logout;
                        $check_admin_area = $request->user()->admin_area;
                        $check_admin_customer = Customer::where('admin_area', $check_admin_area)->first();
                        // dd($check_admin_customer);
                        if($check_admin_customer != null) 
                        {

                            if(Auth::user()->rights_area == '1') {
                        
                                    $admin_check = $request->user()->admin_area;
                        
                                    $user = Customer::select('admin_area')->where('admin_area', $admin_check)->first();
                                    // $admin_area = $user->admin_area;
                                    // dd($user);

                                    //check admin area between customers and users;
                                    if($user != null)
                                    {
                                        $admin_area = $user->admin_area;

                                      /*   if(Auth::user()->role == '1')
                                        {
                                            $request->authenticate();
                                            $request->session()->regenerate();
                                            return redirect()->route('webpanel');
                                
                                        } else { */
                            
                                            if(Auth::user()->admin_area ==  $admin_area) {

                                            $request->authenticate();
                                            $request->session()->regenerate();
                                            // return redirect()->route('portal');
                                            return redirect()->action(
                                                // [PortalCustomerController::class, 'customerView']
                                                [PortalCustomerController::class, 'dashboardCharts']
                                            );

                                            } else {

                                                return back();
                                            }

                                        // }
                                        
                                    } else {

                                        return redirect()->route('portal');

                                    }
                
                            } elseif (Auth::user()->role == '1') {
                                            
                                // return redirect()->route('portal.sign');
                                return redirect()->route('webpanel.report');
                            
                            } else {
                                
                                return redirect()->route('portal.sign');
                            } 

                        } else {
                            // not admin_area at table customes;
                            Auth::guard('web')->logout();
                            $request->session()->invalidate();
                            $request->session()->regenerateToken();
                            return redirect('/')->with('error_active', 'กรุณาติดต่อผู้ดูแล');
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
