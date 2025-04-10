<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function maintenanceWeb(Request $request)
    {

        if($request->has('submit_setting') == true)
        {
            $maintenance_status = $request->maintenance_status;
            $allowed_maintenance_status = $request->allowed_maintenance_status;
            
            // dd($allowed_maintenance_status);

          /*   $user = User::where('user_id', '!=', '0000')->update ([

                    'maintenance_status' => $maintenance_status,
                    'allowed_maintenance_status' => $allowed_maintenance_status,

                ]); */

                $user = Setting::where('setting_id', '=', 'WS01')->update ([

                    'web_status' => $maintenance_status,
                    'allowed_web_status' => $allowed_maintenance_status,

                ]);
                
                
            // dd(gettype($user));
            if($user > 0) {
                return redirect('/webpanel/setting')->with('settings', 'Successfully updated');
            }


        }
    }

    public function index(Request $request)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $setting_view = Setting::select('web_status', 'allowed_web_status')
                        ->where('setting_id', 'WS01')
                        ->first();
        // dd($setting_view->maintenance_status);

        $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id',$code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('webpanel/setting', compact('setting_view', 'status_waiting', 'status_updated', 'status_alert', 'status_registration', 'user_id_admin'));
    }
}
