<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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

            $user = User::where('user_id', '!=', '0000')->update ([

                    'maintenance_status' => $maintenance_status,
                    'allowed_maintenance_status' => $allowed_maintenance_status,

                ]);
                
            // dd(gettype($user));
            if($user > 0) {
                return redirect('/webpanel/setting')->with('settings', 'Successfully updated');
            }


        }
    }

    public function index()
    {
        $setting_view = User::select('maintenance_status', 'allowed_maintenance_status')
                        ->where('user_id', '!=', '0000')
                        ->first();
        // dd($setting_view->maintenance_status);

        return view('webpanel/setting', compact('setting_view'));
    }
}