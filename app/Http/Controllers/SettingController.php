<?php

namespace App\Http\Controllers;

use App\Enums\CustomerStatusEnum;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Setting;

class SettingController extends Controller
{
    public function maintenanceWeb(Request $request)
    {
        if ($request->has('submit_setting') == true) {
            $request->validate([
                'maintenance_status'         => 'required|in:0,1',
                'allowed_maintenance_status' => 'required|in:0,1',
                'del_reportseller'           => 'required|in:0,1',
                'check_edit'                 => 'required|in:0,1',
            ]);

            $maintenance_status         = $request->maintenance_status;
            $allowed_maintenance_status = $request->allowed_maintenance_status;
            $del_reportseller           = $request->del_reportseller;
            $check_edit                 = $request->check_edit;

            Setting::where('setting_id', 'WS01')->update([
                'web_status'         => $maintenance_status,
                'allowed_web_status' => $allowed_maintenance_status,
                'del_reportseller'   => $del_reportseller,
                'check_edit'         => $check_edit,
            ]);

            return redirect('/webpanel/setting')->with('settings', 'Successfully updated');
        }
    }

    public function index(Request $request)
    {
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $setting_view = Setting::select('web_status', 'allowed_web_status', 'del_reportseller', 'check_edit')
            ->where('setting_id', 'WS01')
            ->first();

        $status_registration = Customer::where('status', CustomerStatusEnum::Registration)
            ->whereNotIn('customer_id', $code_notin)
            ->count();

        $status_waiting = Customer::where('status', CustomerStatusEnum::Waiting)
            ->whereNotIn('customer_id', $code_notin)
            ->count();

        $status_updated = Customer::where('status_update', 'updated')
            ->whereNotIn('customer_id', $code_notin)
            ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('webpanel/setting', compact('setting_view', 'status_waiting', 'status_updated', 'status_alert', 'status_registration', 'user_id_admin'));
    }
}
