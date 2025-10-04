<?php

namespace App\Http\Controllers;

use App\Models\LogStatus;
use App\Models\User;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Sleep;
use Illuminate\Support\Facades\DB;

class LogStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    public function statusOnline() 
    {

        
        $dateTime = date_default_timezone_set("Asia/Bangkok");
        //menu;
          //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

          //menu alert;
        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

       /*  $session = DB::table('sessions')->select('last_activity')->first();
        $check = $session->last_activity;

        $arr = (array)(now()->addMinute(-10));
        //    $arr_date = $arr['date'];
        $arr_row = explode(" ",$arr['date']);

        $minutes_to_add = 5;
        $new_time = time() + ($minutes_to_add * 60); // Add 15 minutes in seconds
        // dd($new_time);
        $arr_new_time = explode(" ", date('Y-m-d H:i:s', $new_time));
        // dd($arr_new_time[1]); // Format and display the new time
 */
        $code_notin = ['1111', '5585', '7777', '8888', '9088'];
        $date = now();
        $check_row = User::select('user_id', 'user_code', 'email', 'name', 'last_activity', 'login_date')
                            ->whereNotIn('user_id', $code_notin)
                            ->get();

        // $setting = Setting::where('allowed_web_status', 1)->first();

        foreach($check_row as $row) {
           

                // Sleep::for(1)->second();
                
                return view('webpanel/customer-status', compact(
                                                                'check_row', 
                                                                'status_waiting', 
                                                                'status_registration', 
                                                                'status_updated', 
                                                                'status_alert', 
                                                                'date'
                                                                // 'setting'
                                                            ));
            
        }
        // dd($check->login_date);
        
        // return view('webpanel/customer-status', compact('check_row', 'status_waiting', 'status_registration', 'status_updated', 'status_alert'));
    }

    /**
     * Show the form for creating a new resource.
     */
 /*    public function create()
    {
        $date = now();
   
     
        // return response()->json(['data' => $date]);
    } */

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {

        $dateTime = date_default_timezone_set("Asia/Bangkok");
        //menu;
          //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

          //menu alert;
        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

/*         $code_notin = ['1111', '5585', '7777', '8888', '9088'];
        $date = time();
        $check_row = User::select('user_id', 'user_code', 'email', 'name', 'last_activity', 'login_date')
                            ->whereNotIn('user_id', $code_notin)
                            ->get();
                            dd(($check_row)); */

        $user_id_admin = $request->user()->user_id;
                            // dd($user_id_admin);

        return view('webpanel/status', compact('status_waiting', 'status_registration', 'status_updated', 'status_alert', 'user_id_admin'));

       /*  $code_notin = ['1111', '5585', '7777', '8888', '9088'];
        $date = time();
        $check_row = User::select('user_id', 'user_code', 'email', 'name', 'last_activity', 'login_date')
                            ->whereNotIn('user_id', $code_notin)
                            ->get();
        foreach($check_row as $row) {
           

                // Sleep::for(1)->second();
                // echo json_encode($data); // Convert PHP array to JSON and return
                
                // return view('webpanel/status', compact('check_row', 'status_waiting', 'status_registration', 'status_updated', 'status_alert', 'date'));
            
        } */
       /*  $date = now();
   
        return view('webpanel/status', compact('date')); */
    }

    /**
     * Display the specified resource.
     */
    public function updated(LogStatus $logStatus)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
      /*   $data = [
            "name" => time(),
            "email" => "john@example.com",
            "age" => 30
        ];
        
        $json = json_encode($data);
        echo $json; */

        $code_notin = ['1111', '5585', '7777', '8888', '9088'];
        // DB::statement("SET time_zone = '+07:00'");

     /*    if (app()->environment('local')) {
            DB::statement("SET time_zone = '+07:00'");
        }
 */
        // SET GLOBAL time_zone = '+07:00';

        $setting = Setting::where('setting_id', 'WS01')->first()->web_status;

        $check_row = User::select(
                                    'user_id', 
                                    'user_code', 
                                    'email', 
                                    'name', 
                                    // 'last_activity', 
                                    DB::raw('UNIX_TIMESTAMP(last_activity) as last_activity'),
                                    'login_date'
                                )
                            // ->where('user_id','0000')
                            ->whereNotIn('user_id', $code_notin)
                            // ->where('user_id', '9099')
                            ->get();
                            $date = ["date" => time()];
                            $json = [$check_row, $date];
                            $arr_data = json_encode($json);

                            // return $arr_data;
      
                            return response()->json([
                                'user'    => $check_row,
                                'date'    => $date,
                                'setting' => $setting,
                            ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LogStatus $logStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogStatus $logStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogStatus $logStatus)
    {
        //
    }
}
