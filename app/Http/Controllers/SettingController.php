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

    public function index()
    {
        $setting_view = Setting::select('web_status', 'allowed_web_status')
                        ->where('setting_id', 'WS01')
                        ->first();
        // dd($setting_view->maintenance_status);


        $status_waiting = Customer::where('status', '0')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        return view('webpanel/setting', compact('setting_view', 'status_waiting', 'status_updated', 'status_alert'));
    }
}
