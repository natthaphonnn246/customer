<?php

namespace App\Http\Controllers\Auth;

use App\Models\Setting;
use App\Models\User;
use App\Models\Customer;
use App\Models\LogStatus;
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

        date_default_timezone_set("Asia/Bangkok");
        $date_time = date("Y-m-d H:i:s");
        // dd($date);

        $date = time();

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            ]);
        
        $check_email_rights = $request->email;
        // dd($check_email_rights);
    
        if (Auth::attempt($credentials) && Auth::user()->status_checked == 'active')
        {
            
                //superadmin;
                if(Auth::user()->user_id == '0000') {

                    //check login;
                    $count_login = User::select('check_login')->where('email',$request->email)->first();
                    // dd(gettype($count_login->check_login));
                    if(($count_login->check_login) == '') {
                        $check_login = User::where('email',$request->email)
                                            ->update([
                                                'check_login' => 0 +1,
                                                'login_date' => $date_time,

                                                ]);

                    } else {
                        $check_login = User::where('email',$request->email)
                                            ->update([
                                                'check_login' => intval($count_login->check_login) +1,
                                                'login_date' => $date_time,
                                                
                                                ]);
                    }

                    //table_log_status;4
                    LogStatus::create([
                                'user_id' => Auth::user()->user_id,
                                'email' => Auth::user()->email,
                                'user_name' => Auth::user()->name,
                                'login_count' => '1',
                                'login_check' => 'success',
                                'login_date' => $date,
                                'ip_address' => $request->ip(),
                                'last_activity' => $date,
                            ]);

                    return redirect('webpanel');
                    
                }
/* if(Auth::user()->status_checked == 'active')
{} */
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

                                                        //check login;
                                                        $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                        // dd(gettype($count_login->check_login));
                                                        if(($count_login->check_login) == '') {
                                                            $check_login = User::where('email',$request->email)
                                                                                ->update([
                                                                                    'check_login' => 0 +1,
                                                                                    'login_date' => $date_time,

                                                                                    ]);

                                                        } else {
                                                            $check_login = User::where('email',$request->email)
                                                                                ->update([
                                                                                    'check_login' => intval($count_login->check_login) +1,
                                                                                    'login_date' => $date_time,
                                                                                    
                                                                                    ]);
                                                        }
                                                        //table_log_status;
                                                        LogStatus::create([
                                                                    'user_id' => Auth::user()->user_id,
                                                                    'email' => Auth::user()->email,
                                                                    'user_name' => Auth::user()->name,
                                                                    'login_count' => '1',
                                                                    'login_check' => 'success',
                                                                    'login_date' =>  $date,
                                                                    'ip_address' => $request->ip(),
                                                                    'last_activity' => $date,
                                                                ]);

                                                        // $check_login = User::where('email',$request->email)->update(['check_login' => 'login']);
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

                                                     //check login;
                                                     $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                     // dd(gettype($count_login->check_login));
                                                     if(($count_login->check_login) == '') {
                                                         $check_login = User::where('email',$request->email)
                                                                             ->update([
                                                                                 'check_login' => 0 +1,
                                                                                 'login_date' => $date_time,

                                                                                 ]);

                                                     } else {
                                                         $check_login = User::where('email',$request->email)
                                                                             ->update([
                                                                                 'check_login' => intval($count_login->check_login) +1,
                                                                                 'login_date' => $date_time,
                                                                                 
                                                                                 ]);
                                                     }
                                                     //table_log_status;
                                                     LogStatus::create([
                                                                 'user_id' => Auth::user()->user_id,
                                                                 'email' => Auth::user()->email,
                                                                 'user_name' => Auth::user()->name,
                                                                 'login_count' => '1',
                                                                 'login_check' => 'success',
                                                                 'login_date' =>  $date,
                                                                 'ip_address' => $request->ip(),
                                                                 'last_activity' => $date,
                                                             ]);

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
                                            
                                             //check login;
                                             $count_login = User::select('check_login')->where('email',$request->email)->first();
                                             // dd(gettype($count_login->check_login));
                                             if(($count_login->check_login) == '') {
                                                 $check_login = User::where('email',$request->email)
                                                                     ->update([
                                                                         'check_login' => 0 +1,
                                                                         'login_date' => $date_time,

                                                                         ]);

                                             } else {
                                                 $check_login = User::where('email',$request->email)
                                                                     ->update([
                                                                         'check_login' => intval($count_login->check_login) +1,
                                                                         'login_date' => $date_time,
                                                                         
                                                                         ]);
                                             }
                                             //table_log_status;
                                             LogStatus::create([
                                                         'user_id' => Auth::user()->user_id,
                                                         'email' => Auth::user()->email,
                                                         'user_name' => Auth::user()->name,
                                                         'login_count' => '1',
                                                         'login_check' => 'success',
                                                         'login_date' =>  $date,
                                                         'ip_address' => $request->ip(),
                                                         'last_activity' => $date,
                                                     ]);

                                            // return redirect()->route('portal.sign');
                                            return redirect()->route('webpanel.report');
                                        
                                        } else {

                                             //check login;
                                             $count_login = User::select('check_login')->where('email',$request->email)->first();
                                             // dd(gettype($count_login->check_login));
                                             if(($count_login->check_login) == '') {
                                                 $check_login = User::where('email',$request->email)
                                                                     ->update([
                                                                         'check_login' => 0 +1,
                                                                         'login_date' => $date_time,

                                                                         ]);

                                             } else {
                                                 $check_login = User::where('email',$request->email)
                                                                     ->update([
                                                                         'check_login' => intval($count_login->check_login) +1,
                                                                         'login_date' => $date_time,
                                                                         
                                                                         ]);
                                             }
                                             //table_log_status;
                                             LogStatus::create([
                                                         'user_id' => Auth::user()->user_id,
                                                         'email' => Auth::user()->email,
                                                         'user_name' => Auth::user()->name,
                                                         'login_count' => '1',
                                                         'login_check' => 'success',
                                                         'login_date' =>  $date,
                                                         'ip_address' => $request->ip(),
                                                         'last_activity' => $date,
                                                     ]);

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

                                                     //check login;
                                                     $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                     // dd(gettype($count_login->check_login));
                                                     if(($count_login->check_login) == '') {
                                                         $check_login = User::where('email',$request->email)
                                                                             ->update([
                                                                                 'check_login' => 0 +1,
                                                                                 'login_date' => $date_time,

                                                                                 ]);

                                                     } else {
                                                         $check_login = User::where('email',$request->email)
                                                                             ->update([
                                                                                 'check_login' => intval($count_login->check_login) +1,
                                                                                 'login_date' => $date_time,
                                                                                 
                                                                                 ]);
                                                     }
                                                     //table_log_status;
                                                     LogStatus::create([
                                                                 'user_id' => Auth::user()->user_id,
                                                                 'email' => Auth::user()->email,
                                                                 'user_name' => Auth::user()->name,
                                                                 'login_count' => '1',
                                                                 'login_check' => 'success',
                                                                 'login_date' =>  $date,
                                                                 'ip_address' => $request->ip(),
                                                                 'last_activity' => $date,
                                                             ]);

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

                                                 //check login;
                                                 $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                 // dd(gettype($count_login->check_login));
                                                 if(($count_login->check_login) == '') {
                                                     $check_login = User::where('email',$request->email)
                                                                         ->update([
                                                                             'check_login' => 0 +1,
                                                                             'login_date' => $date_time,

                                                                             ]);

                                                 } else {
                                                     $check_login = User::where('email',$request->email)
                                                                         ->update([
                                                                             'check_login' => intval($count_login->check_login) +1,
                                                                             'login_date' => $date_time,
                                                                             
                                                                             ]);
                                                 }
                                                 //table_log_status;
                                                 LogStatus::create([
                                                             'user_id' => Auth::user()->user_id,
                                                             'email' => Auth::user()->email,
                                                             'user_name' => Auth::user()->name,
                                                             'login_count' => '1',
                                                             'login_check' => 'success',
                                                             'login_date' =>  $date,
                                                             'ip_address' => $request->ip(),
                                                              'last_activity' => $date,
                                                         ]);
                                                
                                                return redirect()->route('portal');
                                            }
                        
                                    } elseif (Auth::user()->role == '1') {
                                            
                                         //check login;
                                         $count_login = User::select('check_login')->where('email',$request->email)->first();
                                         // dd(gettype($count_login->check_login));
                                         if(($count_login->check_login) == '') {
                                             $check_login = User::where('email',$request->email)
                                                                 ->update([
                                                                     'check_login' => 0 +1,
                                                                     'login_date' => $date_time,

                                                                     ]);

                                         } else {
                                             $check_login = User::where('email',$request->email)
                                                                 ->update([
                                                                     'check_login' => intval($count_login->check_login) +1,
                                                                     'login_date' => $date_time,
                                                                     
                                                                     ]);
                                         }
                                         //table_log_status;
                                         LogStatus::create([
                                                     'user_id' => Auth::user()->user_id,
                                                     'email' => Auth::user()->email,
                                                     'user_name' => Auth::user()->name,
                                                     'login_count' => '1',
                                                     'login_check' => 'success',
                                                     'login_date' =>  $date,
                                                     'ip_address' => $request->ip(),
                                                     'last_activity' => $date,
                                                 ]);
                                        // return redirect()->route('portal.sign');
                                        return redirect()->route('webpanel.report');
                                    
                                    } else {

                                         //check login;
                                         $count_login = User::select('check_login')->where('email',$request->email)->first();
                                         // dd(gettype($count_login->check_login));
                                         if(($count_login->check_login) == '') {
                                             $check_login = User::where('email',$request->email)
                                                                 ->update([
                                                                     'check_login' => 0 +1,
                                                                     'login_date' => $date_time,

                                                                     ]);

                                         } else {
                                             $check_login = User::where('email',$request->email)
                                                                 ->update([
                                                                     'check_login' => intval($count_login->check_login) +1,
                                                                     'login_date' => $date_time,
                                                                     
                                                                     ]);
                                         }
                                         //table_log_status;
                                         LogStatus::create([
                                                     'user_id' => Auth::user()->user_id,
                                                     'email' => Auth::user()->email,
                                                     'user_name' => Auth::user()->name,
                                                     'login_count' => '1',
                                                     'login_check' => 'success',
                                                     'login_date' =>  $date,
                                                     'ip_address' => $request->ip(),
                                                     'last_activity' => $date,
                                                 ]);
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

                                             //check login;
                                             $count_login = User::select('check_login')->where('email',$request->email)->first();
                                             // dd(gettype($count_login->check_login));
                                             if(($count_login->check_login) == '') {
                                                 $check_login = User::where('email',$request->email)
                                                                     ->update([
                                                                         'check_login' => 0 +1,
                                                                         'login_date' => $date_time,

                                                                         ]);

                                             } else {
                                                 $check_login = User::where('email',$request->email)
                                                                     ->update([
                                                                         'check_login' => intval($count_login->check_login) +1,
                                                                         'login_date' => $date_time,
                                                                         
                                                                         ]);
                                             }
                                             //table_log_status;
                                             LogStatus::create([
                                                         'user_id' => Auth::user()->user_id,
                                                         'email' => Auth::user()->email,
                                                         'user_name' => Auth::user()->name,
                                                         'login_count' => '1',
                                                         'login_check' => 'success',
                                                         'login_date' =>  $date,
                                                         'ip_address' => $request->ip(),
                                                         'last_activity' => $date,
                                                     ]);

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

                                         //check login;
                                         $count_login = User::select('check_login')->where('email',$request->email)->first();
                                         // dd(gettype($count_login->check_login));
                                         if(($count_login->check_login) == '') {
                                             $check_login = User::where('email',$request->email)
                                                                 ->update([
                                                                     'check_login' => 0 +1,
                                                                     'login_date' => $date_time,

                                                                     ]);

                                         } else {
                                             $check_login = User::where('email',$request->email)
                                                                 ->update([
                                                                     'check_login' => intval($count_login->check_login) +1,
                                                                     'login_date' => $date_time,
                                                                     
                                                                     ]);
                                         }
                                         //table_log_status;
                                         LogStatus::create([
                                                     'user_id' => Auth::user()->user_id,
                                                     'email' => Auth::user()->email,
                                                     'user_name' => Auth::user()->name,
                                                     'login_count' => '1',
                                                     'login_check' => 'success',
                                                     'login_date' =>  $date,
                                                     'ip_address' => $request->ip(),
                                                     'last_activity' => $date,
                                                 ]);
                                        return redirect()->route('portal');

                                    }
                
                            } elseif (Auth::user()->role == '1') {
                                            
                                 //check login;
                                 $count_login = User::select('check_login')->where('email',$request->email)->first();
                                 // dd(gettype($count_login->check_login));
                                 if(($count_login->check_login) == '') {
                                     $check_login = User::where('email',$request->email)
                                                         ->update([
                                                             'check_login' => 0 +1,
                                                             'login_date' => $date_time,

                                                             ]);

                                 } else {
                                     $check_login = User::where('email',$request->email)
                                                         ->update([
                                                             'check_login' => intval($count_login->check_login) +1,
                                                             'login_date' => $date_time,
                                                             
                                                             ]);
                                 }
                                 //table_log_status;
                                 LogStatus::create([
                                             'user_id' => Auth::user()->user_id,
                                             'email' => Auth::user()->email,
                                             'user_name' => Auth::user()->name,
                                             'login_count' => '1',
                                             'login_check' => 'success',
                                             'login_date' =>  $date,
                                             'ip_address' => $request->ip(),
                                             'last_activity' => $date,
                                         ]);
                                // return redirect()->route('portal.sign');
                                return redirect()->route('webpanel.report');
                            
                            } else {
                                
                                 //check login;
                                 $count_login = User::select('check_login')->where('email',$request->email)->first();
                                 // dd(gettype($count_login->check_login));
                                 if(($count_login->check_login) == '') {
                                     $check_login = User::where('email',$request->email)
                                                         ->update([
                                                             'check_login' => 0 +1,
                                                             'login_date' => $date_time,

                                                             ]);

                                 } else {
                                     $check_login = User::where('email',$request->email)
                                                         ->update([
                                                             'check_login' => intval($count_login->check_login) +1,
                                                             'login_date' => $date_time,
                                                             
                                                             ]);
                                 }
                                 //table_log_status;
                                 LogStatus::create([
                                             'user_id' => Auth::user()->user_id,
                                             'email' => Auth::user()->email,
                                             'user_name' => Auth::user()->name,
                                             'login_count' => '1',
                                             'login_check' => 'success',
                                             'login_date' =>  $date,
                                             'ip_address' => $request->ip(),
                                             'last_activity' => $date,
                                         ]);
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
 
            } 
             
            else {


                $check_email = User::where('email', $request->email)->first();
                // dd($check_email->email);
                //table_log_status;

                if((Auth::attempt($credentials))) {
                    LogStatus::create([
                        'user_id' => Auth::user()->user_id,
                        'email' => Auth::user()->email,
                        'user_name' => Auth::user()->name,
                        'login_count' => '1',
                        'login_check' => 'fail',
                        'login_date' =>  $date,
                        'ip_address' => $request->ip(),
                        'last_activity' => $date,
                    ]);

                    $request->authenticate();

                    $request->session()->regenerate();
                    
                    // return redirect()->intended(route('login', absolute: false));

                    return redirect()->back()->with('login_fail', 'fail');
                
                } 

                   /*  dd('fail'); */
                   /*  $request->authenticate();

                    $request->session()->regenerate(); */

                    // return redirect()->intended(route('login', absolute: false));

                    // spam email or password fail;
                    LogStatus::create([
                        'user_id' => 'spam',
                        'email' => $request->email,
                        'user_name' => 'spam',
                        'login_count' => '1',
                        'login_check' => 'error',
                        'login_date' =>  $date,
                        'ip_address' => $request->ip(),
                        'last_activity' => $date,
                    ]);
                
                    return redirect()->back()->with('login_error', 'error');
                
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
