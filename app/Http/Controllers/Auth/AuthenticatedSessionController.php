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
use Illuminate\Support\Facades\Http;

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
    // public function store(LoginRequest $request): RedirectResponse
    public function store(LoginRequest $request) : RedirectResponse
    {

        // if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        // if ($request->has('g-recaptcha-response') && !empty($request->input('g-recaptcha-response'))) {
            
           /*  $secretKey = "6LfCCxkrAAAAAL2vzY9zfXfBfQ1JMHoOjzrOWQ2K";
            $response = $_POST['g-recaptcha-response'];
            $remoteIP = $_SERVER['REMOTE_ADDR'];
            $verifyUrl = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secreat=$secretKey&response=$response&remoteip=$remoteIP");
            $captchaSuccess = json_decode($verifyUrl); */
     
            //chat GPT;
                // Validate ว่า g-recaptcha-response ต้องมี
/* 
                $request->validate([
                    'g-recaptcha-response' => 'required',
                ]);
            
                // ยิง request ไปเช็คกับ Google
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => env('GOOGLE_RECAPTCHA_SECRET'), // key ลับของคุณ (เก็บใน .env)
                    'response' => $request->input('g-recaptcha-response'),
                    'remoteip' => $request->ip(), // IP ผู้ใช้ (optional)
                ]);
            
                $responseBody = $response->json();
            
                if (!($responseBody['success'] ?? false)) {
                    return back()->with('recaptcha_error', 'recaptcha_error');
                }
             */
                // ถ้า success = true
                // ทำงานต่อได้ เช่น save ข้อมูล
                // return redirect()->back()->with('message', 'ส่งข้อมูลเรียบร้อยแล้ว!');
            // }

                //recaptcha;
                $request->validate([
                    'g-recaptcha-response' => ['required', new \App\Rules\Recaptcha],
                ]);
            
                //login;
                $credentials = $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                    ]);
                    
                date_default_timezone_set("Asia/Bangkok");
                $date_time = date("Y-m-d H:i:s");
                $date = time();

                $attemptKey = 'login_attempts_' . sha1($request->email . '|' . $request->ip());
                $attempts = cache($attemptKey, 0); //จำนวนครั้งที่ล็ฮกอินได้;

                $user_admin = User::where('email', $request->email)->first();

                
                if ($user_admin && $user_admin->is_blocked) {
                    return back()->with(['email' => 'บัญชีถูกบล็อกชั่วคราว']);

                }

                if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    
                    cache([$attemptKey => $attempts + 1]); //บล็อกถาวร;

                    if ($user_admin && $attempts >= 5) {

                        $user_admin->is_blocked = true;
                        $user_admin->save();
                        
                        return back()->with(['email' => 'บัญชีถูกบล็อกชั่วคราว']);
                    }

                    return back()->with(['attepmt_fail' => 'ข้อมูลไม่ถูกต้อง']);

                }

                cache()->forget($attemptKey); // ถ้า login สำเร็จ → รีเซ็ต
                
                $check_email_rights = $request->email;
                // dd($check_email_rights);
            
                if (Auth::attempt($credentials) && Auth::user()->status_checked == 'active' || Auth::user()->is_blocked)
                {
                    
                        // เพิ่ม session สำหรับ BlockAIAgents middleware
                        session(['user_logged_in' => true]);

                        //superadmin;
                        if(Auth::user()->user_id == '0000' || Auth::user()->user_id == '4494' || Auth::user()->user_id == '9000') {

                            //check login;
                            $count_login = User::select('check_login')->where('email',$request->email)->first();
                            // dd(gettype($count_login->check_login));
                            if(empty($count_login->check_login)) {
                               /*  $check_login = User::where('email',$request->email)
                                                    ->update([
                                                        'check_login' => 0 +1,
                                                        'login_date' => $date_time,

                                                    ]); */

                                    $login_attempts = User::where('email',$request->email)->first();

                                    $login_attempts->check_login = 0+1;
                                    $login_attempts->login_date = $date_time;
                                    $login_attempts->save();

                            } else {
                               /*  $check_login = User::where('email',$request->email)
                                                    ->update([
                                                        'check_login' => intval($count_login->check_login) +1,
                                                        'login_date' => $date_time,
                                                    
                                                    ]); */

                                    $login_attempts = User::where('email',$request->email)->first();

                                    $login_attempts->check_login = intval($count_login->check_login) +1;
                                    $login_attempts->login_date = $date_time;
                                    $login_attempts->save();
                                
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


                            // if(Auth::user()->role == '2') 
                            if(Auth::user()->admin_role === 1) {

                                return redirect('webpanel');
                            
                            } elseif (Auth::user()->role === 2) {

                                return redirect('webpanel');

                            } elseif (Auth::user()->role === 1) {

                                return redirect()->route('admin.report');

                            } else {
                                
                                return redirect()->route('portal');
                            }
                            
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
                                            // return back()->with('allowed_status', 'ปิดปรับปรุงระบบ');
                                            // ->with('allowed_status', 'ปิดปรับปรุงระบบ');
                                        } else {

                                            //check amdin_area at table: customers if null redirect to logout;
                                            $check_admin_area = $request->user()->admin_area;
                                            $check_admin_customer = Customer::where('admin_area', $check_admin_area)->first();
                                            // dd($check_admin_customer);
                                            if($check_admin_customer != null) 
                                            {
                                                // dd('Please select');
                                            
                                                if(Auth::user()->rights_area === 1)
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
                                                                if(empty($count_login->check_login)) {
                                                                    /* $check_login = User::where('email',$request->email)
                                                                                        ->update([
                                                                                            'check_login' => 0 +1,
                                                                                            'login_date' => $date_time,

                                                                                            ]); */
                                                                        $login_attempts = User::where('email',$request->email)->first();

                                                                        $login_attempts->check_login = 0+1;
                                                                        $login_attempts->login_date = $date_time;
                                                                        $login_attempts->save();

                                                                } else {
                                                                   /*  $check_login = User::where('email',$request->email)
                                                                                        ->update([
                                                                                            'check_login' => intval($count_login->check_login) +1,
                                                                                            'login_date' => $date_time,
                                                                                            
                                                                                            ]); */

                                                                        $login_attempts = User::where('email',$request->email)->first();

                                                                        $login_attempts->check_login = intval($count_login->check_login) +1;
                                                                        $login_attempts->login_date = $date_time;
                                                                        $login_attempts->save();
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
// dd('dd');
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
                                                            if(empty($count_login->check_login)) {
                                                                /* $check_login = User::where('email',$request->email)
                                                                                    ->update([
                                                                                        'check_login' => 0 +1,
                                                                                        'login_date' => $date_time,

                                                                                        ]); */

                                                                    $login_attempts = User::where('email',$request->email)->first();

                                                                    $login_attempts->check_login = 0+1;
                                                                    $login_attempts->login_date = $date_time;
                                                                    $login_attempts->save();

                                                            } else {
                                                                /* $check_login = User::where('email',$request->email)
                                                                                    ->update([
                                                                                        'check_login' => intval($count_login->check_login) +1,
                                                                                        'login_date' => $date_time,
                                                                                        
                                                                                        ]); */

                                                                    $login_attempts = User::where('email',$request->email)->first();

                                                                    $login_attempts->check_login = intval($count_login->check_login) +1;
                                                                    $login_attempts->login_date = $date_time;
                                                                    $login_attempts->save();

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
                                                } elseif (Auth::user()->role === 1) {
                                                    
                                                    //check login;
                                                    $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                    // dd(gettype($count_login->check_login));
                                                    if(empty($count_login->check_login)) {
                                                        /* $check_login = User::where('email',$request->email)
                                                                            ->update([
                                                                                'check_login' => 0 +1,
                                                                                'login_date' => $date_time,

                                                                                ]); */

                                                            $login_attempts = User::where('email',$request->email)->first();

                                                            $login_attempts->check_login = 0+1;
                                                            $login_attempts->login_date = $date_time;
                                                            $login_attempts->save();

                                                    } else {
                                                        /* $check_login = User::where('email',$request->email)
                                                                            ->update([
                                                                                'check_login' => intval($count_login->check_login) +1,
                                                                                'login_date' => $date_time,
                                                                                
                                                                                ]); */

                                                            $login_attempts = User::where('email',$request->email)->first();

                                                            $login_attempts->check_login = intval($count_login->check_login) +1;
                                                            $login_attempts->login_date = $date_time;
                                                            $login_attempts->save();

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
                                                    return redirect()->route('admin.report');
                                                
                                                } else {

                                                    //check login;
                                                    $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                    // dd(gettype($count_login->check_login));
                                                    if(empty($count_login->check_login)) {
                                                        /* $check_login = User::where('email',$request->email)
                                                                            ->update([
                                                                                'check_login' => 0 +1,
                                                                                'login_date' => $date_time,

                                                                                ]); */

                                                            $login_attempts = User::where('email',$request->email)->first();

                                                            $login_attempts->check_login = 0+1;
                                                            $login_attempts->login_date = $date_time;
                                                            $login_attempts->save();

                                                    } else {
                                                        /* $check_login = User::where('email',$request->email)
                                                                            ->update([
                                                                                'check_login' => intval($count_login->check_login) +1,
                                                                                'login_date' => $date_time,
                                                                                
                                                                                ]); */

                                                            $login_attempts = User::where('email',$request->email)->first();

                                                            $login_attempts->check_login = intval($count_login->check_login) +1;
                                                            $login_attempts->login_date = $date_time;
                                                            $login_attempts->save();

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

                                                // dd('dd');
                                                // return redirect()->route('portal');
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


                                            if(Auth::user()->rights_area === 1)
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
                                                            if(empty($count_login->check_login)) {
                                                                /* $check_login = User::where('email',$request->email)
                                                                                    ->update([
                                                                                        'check_login' => 0 +1,
                                                                                        'login_date' => $date_time,

                                                                                        ]); */

                                                                    $login_attempts = User::where('email',$request->email)->first();

                                                                    $login_attempts->check_login = 0+1;
                                                                    $login_attempts->login_date = $date_time;
                                                                    $login_attempts->save();

                                                            } else {
                                                               /*  $check_login = User::where('email',$request->email)
                                                                                    ->update([
                                                                                        'check_login' => intval($count_login->check_login) +1,
                                                                                        'login_date' => $date_time,
                                                                                        
                                                                                        ]); */

                                                                    $login_attempts = User::where('email',$request->email)->first();

                                                                    $login_attempts->check_login = intval($count_login->check_login) +1;
                                                                    $login_attempts->login_date = $date_time;
                                                                    $login_attempts->save();

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

                                                                /// ปิดระบบ;
                                                                // return back();
                                                                Auth::guard('web')->logout();
                                                                $request->session()->invalidate();
                                                                $request->session()->regenerateToken();
                                                                return redirect()->back()->with('login_fail', 'fail');
                                                            }

                                                        // }
                                                        
                                                    } else {

                                                        //check login;
                                                        $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                        // dd(gettype($count_login->check_login));
                                                        if(empty($count_login->check_login)) {
                                                           /*  $check_login = User::where('email',$request->email)
                                                                                ->update([
                                                                                    'check_login' => 0 +1,
                                                                                    'login_date' => $date_time,

                                                                                    ]); */

                                                                $login_attempts = User::where('email',$request->email)->first();

                                                                $login_attempts->check_login = 0+1;
                                                                $login_attempts->login_date = $date_time;
                                                                $login_attempts->save();

                                                        } else {
                                                            /* $check_login = User::where('email',$request->email)
                                                                                ->update([
                                                                                    'check_login' => intval($count_login->check_login) +1,
                                                                                    'login_date' => $date_time,
                                                                                    
                                                                                    ]); */

                                                                $login_attempts = User::where('email',$request->email)->first();

                                                                $login_attempts->check_login = intval($count_login->check_login) +1;
                                                                $login_attempts->login_date = $date_time;
                                                                $login_attempts->save();

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
                                
                                            } elseif (Auth::user()->role === 1) {
                                                    
                                                //check login;
                                                $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                // dd(gettype($count_login->check_login));
                                                if(empty($count_login->check_login)) {
                                                    /* $check_login = User::where('email',$request->email)
                                                                        ->update([
                                                                            'check_login' => 0 +1,
                                                                            'login_date' => $date_time,

                                                                            ]); */

                                                    $login_attempts = User::where('email',$request->email)->first();

                                                    $login_attempts->check_login = 0+1;
                                                    $login_attempts->login_date = $date_time;
                                                    $login_attempts->save();

                                                } else {
                                                   /*  $check_login = User::where('email',$request->email)
                                                                        ->update([
                                                                            'check_login' => intval($count_login->check_login) +1,
                                                                            'login_date' => $date_time,
                                                                            
                                                                            ]); */

                                                        $login_attempts = User::where('email',$request->email)->first();

                                                        $login_attempts->check_login = intval($count_login->check_login) +1;
                                                        $login_attempts->login_date = $date_time;
                                                        $login_attempts->save();

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
                                                return redirect()->route('admin.report');
                                            
                                            } else {

                                                //check login;
                                                $count_login = User::select('check_login')->where('email',$request->email)->first();
                                                // dd(gettype($count_login->check_login));
                                                if(empty($count_login->check_login)) {
                                                    /* $check_login = User::where('email',$request->email)
                                                                        ->update([
                                                                            'check_login' => 0 +1,
                                                                            'login_date' => $date_time,

                                                                            ]); */

                                                        $login_attempts = User::where('email',$request->email)->first();

                                                        $login_attempts->check_login = 0+1;
                                                        $login_attempts->login_date = $date_time;
                                                        $login_attempts->save();

                                                } else {
                                                    /* $check_login = User::where('email',$request->email)
                                                                        ->update([
                                                                            'check_login' => intval($count_login->check_login) +1,
                                                                            'login_date' => $date_time,
                                                                            
                                                                            ]); */

                                                        $login_attempts = User::where('email',$request->email)->first();

                                                        $login_attempts->check_login = intval($count_login->check_login) +1;
                                                        $login_attempts->login_date = $date_time;
                                                        $login_attempts->save();

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

                                    if(Auth::user()->rights_area === 1) {
                                
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
                                                    if(empty($count_login->check_login)) {
                                                        /* $check_login = User::where('email',$request->email)
                                                                            ->update([
                                                                                'check_login' => 0 +1,
                                                                                'login_date' => $date_time,

                                                                                ]); */

                                                            $login_attempts = User::where('email',$request->email)->first();

                                                            $login_attempts->check_login = 0+1;
                                                            $login_attempts->login_date = $date_time;
                                                            $login_attempts->save();

                                                    } else {
                                                        /* $check_login = User::where('email',$request->email)
                                                                            ->update([
                                                                                'check_login' => intval($count_login->check_login) +1,
                                                                                'login_date' => $date_time,
                                                                                
                                                                                ]); */

                                                            $login_attempts = User::where('email',$request->email)->first();

                                                            $login_attempts->check_login = intval($count_login->check_login) +1;
                                                            $login_attempts->login_date = $date_time;
                                                            $login_attempts->save();

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
                                                if(empty($count_login->check_login)) {
                                                   /*  $check_login = User::where('email',$request->email)
                                                                        ->update([
                                                                            'check_login' => 0 +1,
                                                                            'login_date' => $date_time,

                                                                            ]); */

                                                        $login_attempts = User::where('email',$request->email)->first();

                                                        $login_attempts->check_login = 0+1;
                                                        $login_attempts->login_date = $date_time;
                                                        $login_attempts->save();

                                                } else {
                                                    /* $check_login = User::where('email',$request->email)
                                                                        ->update([
                                                                            'check_login' => intval($count_login->check_login) +1,
                                                                            'login_date' => $date_time,
                                                                            
                                                                            ]); */

                                                        $login_attempts = User::where('email',$request->email)->first();

                                                        $login_attempts->check_login = intval($count_login->check_login) +1;
                                                        $login_attempts->login_date = $date_time;
                                                        $login_attempts->save();

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
                        
                                    } elseif (Auth::user()->role === 1) {
                                                    
                                        //check login;
                                        $count_login = User::select('check_login')->where('email',$request->email)->first();
                                        // dd(gettype($count_login->check_login));
                                        if(empty($count_login->check_login)) {
                                            /* $check_login = User::where('email',$request->email)
                                                                ->update([
                                                                    'check_login' => 0 +1,
                                                                    'login_date' => $date_time,

                                                                    ]); */

                                                $login_attempts = User::where('email',$request->email)->first();

                                                $login_attempts->check_login = 0+1;
                                                $login_attempts->login_date = $date_time;
                                                $login_attempts->save();

                                        } else {
                                            /* $check_login = User::where('email',$request->email)
                                                                ->update([
                                                                    'check_login' => intval($count_login->check_login) +1,
                                                                    'login_date' => $date_time,
                                                                    
                                                                    ]); */


                                                $login_attempts = User::where('email',$request->email)->first();

                                                $login_attempts->check_login = intval($count_login->check_login) +1;
                                                $login_attempts->login_date = $date_time;
                                                $login_attempts->save();

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
                                        return redirect()->route('admin.report');
                                    
                                    } else {
                                        
                                        //check login;
                                        $count_login = User::select('check_login')->where('email',$request->email)->first();
                                        // dd(gettype($count_login->check_login));
                                        if(empty($count_login->check_login)) {
                                            /* $check_login = User::where('email',$request->email)
                                                                ->update([
                                                                    'check_login' => 0 +1,
                                                                    'login_date' => $date_time,

                                                                    ]); */

                                                $login_attempts = User::where('email',$request->email)->first();

                                                $login_attempts->check_login = 0+1;
                                                $login_attempts->login_date = $date_time;
                                                $login_attempts->save();

                                        } else {
                                           /*  $check_login = User::where('email',$request->email)
                                                                ->update([
                                                                    'check_login' => intval($count_login->check_login) +1,
                                                                    'login_date' => $date_time,
                                                                    
                                                                    ]); */

                                                $login_attempts = User::where('email',$request->email)->first();

                                                $login_attempts->check_login = intval($count_login->check_login) +1;
                                                $login_attempts->login_date = $date_time;
                                                $login_attempts->save();
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

                        // เพิ่ม session สำหรับ BlockAIAgents middleware
                        session(['user_logged_in' => true]);
                        
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

                            /* $request->authenticate();

                            $request->session()->regenerate(); */

                            // return redirect()->back()->with('login_fail', 'fail');

                            Auth::guard('web')->logout();
                            $request->session()->invalidate();
                            $request->session()->regenerateToken();
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

                // } //recaptcha;

            // เพิ่ม return ค่า default
            // return back()->with('recaptcha_error', 'recaptcha_error');;
    
        
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
