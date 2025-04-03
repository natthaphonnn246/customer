<?php

namespace App\Http\Controllers;

use App\Models\LogStatus;
use App\Models\User;
use App\Models\Customer;
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
        $code_notin = ['1111', '5585', '7777', '8888', '9002'];

        $check_row = User::select('user_id', 'user_code', 'email', 'name', 'last_activity', 'login_date')
                            ->whereNotIn('user_id', $code_notin)
                            ->get();
        foreach($check_row as $row) {
           

                Sleep::for(1)->second();
                
                return view('webpanel/customer-status', compact('check_row', 'status_waiting', 'status_registration', 'status_updated', 'status_alert'));
            
        }
        // dd($check->login_date);
        
        // return view('webpanel/customer-status', compact('check_row', 'status_waiting', 'status_registration', 'status_updated', 'status_alert'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LogStatus $logStatus)
    {
        //
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
