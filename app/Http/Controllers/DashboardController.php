<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $customer_north = Customer::where('geography', 'ภาคเหนือ')->count();
        $customer_central = Customer::where('geography', 'ภาคกลาง')->count();
        $customer_eastern = Customer::where('geography', 'ภาคตะวันออก')->count();
        $customer_northeast = Customer::where('geography', 'ภาคตะวันออกเฉียงเหนือ')->count();
        $customer_western = Customer::where('geography', 'ภาคตะวันตก')->count();
        $customer_south = Customer::where('geography', 'ภาคใต้')->count();

        //ร้านค้าทั้งหมด;
        $customer_all = Customer::all()->count();
        // dd($customer_all);

        //percentage;
        $percentage_north = ($customer_north / $customer_all) * 100;
        // dd($percentage_north);
        $percentage_central = ($customer_central / $customer_all) * 100;
        $percentage_eastern = ($customer_eastern / $customer_all) * 100;
        $percentage_northeast = ($customer_northeast / $customer_all) * 100;
        $percentage_western = ($customer_western / $customer_all) * 100;
        $percentage_south = ($customer_south / $customer_all) * 100;

        // dd($percentage_north);

        //status_user_north;
        $normal_customer_north = Customer::where('status_user', '')->where('geography', 'ภาคเหนือ')->count();
        $follow_customer_north = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคเหนือ')->count();
        $suspend_customer_north = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคเหนือ')->count();
        $closed_customer_north = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคเหนือ')->count();
        // dd($closed_customer_north);
        // dd($suspend_customer_north);
        
        //percentage of status_customer_north;
        $percentage_normal_customer_north = ($normal_customer_north / $customer_north) * 100;
        $percentage_follow_customer_north = ($follow_customer_north / $customer_north) * 100;
        $percentage_suspend_customer_north = ($suspend_customer_north / $customer_north) * 100;
        $percentage_closed_customer_north = ($closed_customer_north / $customer_north) * 100;
        // dd($percentage_normal_customer_north);

         //status_user_central;
         $normal_customer_central = Customer::where('status_user', '')->where('geography', 'ภาคกลาง')->count();
         $follow_customer_central = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคกลาง')->count();
         $suspend_customer_central = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคกลาง')->count();
         $closed_customer_central = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคกลาง')->count();
         // dd($suspend_customer_central);
         
         //percentage of status_customer_central;
         $percentage_normal_customer_central = ($normal_customer_central / $customer_central) * 100;
         $percentage_follow_customer_central = ($follow_customer_central / $customer_central) * 100;
         $percentage_suspend_customer_central = ($suspend_customer_central / $customer_central) * 100;
         $percentage_closed_customer_central = ($closed_customer_central / $customer_central) * 100;
         // dd($percentage_normal_customer_central);

        //status_user_eastern;
        $normal_customer_eastern = Customer::where('status_user', '')->where('geography', 'ภาคตะวันออก')->count();
        $follow_customer_eastern = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคตะวันออก')->count();
        $suspend_customer_eastern = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคตะวันออก')->count();
        $closed_customer_eastern = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคตะวันออก')->count();
        // dd($suspend_customer_central);
        
        //percentage of status_customer_central;
        $percentage_normal_customer_eastern = ($normal_customer_eastern / $customer_eastern) * 100;
        $percentage_follow_customer_eastern = ($follow_customer_eastern / $customer_eastern) * 100;
        $percentage_suspend_customer_eastern = ($suspend_customer_eastern / $customer_eastern) * 100;
        $percentage_closed_customer_eastern = ($closed_customer_eastern / $customer_eastern) * 100;
        // dd($percentage_normal_customer_central);

         //status_user_northeast;
         $normal_customer_northeast = Customer::where('status_user', '')->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->count();
         $follow_customer_northeast = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->count();
         $suspend_customer_northeast = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->count();
         $closed_customer_northeast = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->count();
         // dd($suspend_customer_central);
         
         //percentage of status_customer_northeast;
         $percentage_normal_customer_northeast = ($normal_customer_northeast / $customer_northeast) * 100;
         $percentage_follow_customer_northeast = ($follow_customer_northeast / $customer_northeast) * 100;
         $percentage_suspend_customer_northeast = ($suspend_customer_northeast / $customer_northeast) * 100;
         $percentage_closed_customer_northeast = ($closed_customer_northeast / $customer_northeast) * 100;
         
         // dd($percentage_normal_customer_northeast);

          //status_user_western;
          $normal_customer_western = Customer::where('status_user', '')->where('geography', 'ภาคตะวันตก')->count();
          $follow_customer_western = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคตะวันตก')->count();
          $suspend_customer_western = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคตะวันตก')->count();
          $closed_customer_western = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคตะวันตก')->count();
          // dd($suspend_customer_central);
          
          //percentage of status_customer_western;
          $percentage_normal_customer_western = ($normal_customer_western / $customer_western) * 100;
          $percentage_follow_customer_western = ($follow_customer_western / $customer_western) * 100;
          $percentage_suspend_customer_western = ($suspend_customer_western / $customer_western) * 100;
          $percentage_closed_customer_western = ($closed_customer_western / $customer_western) * 100;
          // dd($percentage_normal_customer_western);

           //status_user_south;
           $normal_customer_south = Customer::where('status_user', '')->where('geography', 'ภาคใต้')->count();
           $follow_customer_south = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคใต้')->count();
           $suspend_customer_south = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคใต้')->count();
           $closed_customer_south = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคใต้')->count();
           // dd($suspend_customer_central);
           
           //percentage of status_customer_south;
           $percentage_normal_customer_south = ($normal_customer_south / $customer_south) * 100;
           $percentage_follow_customer_south = ($follow_customer_south / $customer_south) * 100;
           $percentage_suspend_customer_south = ($suspend_customer_south / $customer_south) * 100;
           $percentage_closed_customer_south = ($closed_customer_south / $customer_south) * 100;
           // dd($percentage_normal_customer_south);


           //status_normal;
           $count_status_normal = Customer::where('status_user', '')->count();
           //status_follow;
           $count_status_follow = Customer::where('status_user', 'กำลังติดตาม')->count();
           //status_suspend;
           $count_status_suspend = Customer::where('status_user', 'ถูกระงับสมาชิก')->count();
           //status_closed;
           $count_status_closed = Customer::whereNotIn('status_user', ['','กำลังติดตาม','ถูกระงับสมาชิก'])->count();
    
           //menu alert;
           $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];
           $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $status_updated = Customer::where('status_update', 'updated')
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $status_alert = $status_waiting + $status_updated;
            $user_id_admin = $request->user()->user_id;

        // dd($customer_view);

        // $row_arr = [$customer_north, $customer_central, $customer_eastern, $customer_northeast, $customer_western, $customer_south];

        return view('webpanel/dashboard', 
        
        compact('customer_north' , 'customer_central', 'customer_eastern', 'customer_northeast', 'customer_western', 'customer_south',
                'percentage_north', 'percentage_central', 'percentage_eastern', 'percentage_northeast', 'percentage_western', 'percentage_south',
                'normal_customer_north', 'follow_customer_north','suspend_customer_north','closed_customer_north', 'percentage_normal_customer_north', 'percentage_follow_customer_north', 'percentage_suspend_customer_north', 'percentage_closed_customer_north',
                'normal_customer_central', 'follow_customer_central','suspend_customer_central','closed_customer_central', 'percentage_normal_customer_central', 'percentage_follow_customer_central', 'percentage_suspend_customer_central','percentage_closed_customer_central',
                'normal_customer_eastern', 'follow_customer_eastern','suspend_customer_eastern','closed_customer_eastern', 'percentage_normal_customer_eastern', 'percentage_follow_customer_eastern', 'percentage_suspend_customer_eastern', 'percentage_closed_customer_eastern',
                'normal_customer_northeast', 'follow_customer_northeast','suspend_customer_northeast', 'closed_customer_northeast', 'percentage_normal_customer_northeast', 'percentage_follow_customer_northeast', 'percentage_suspend_customer_northeast', 'percentage_closed_customer_northeast',
                'normal_customer_western', 'follow_customer_western','suspend_customer_western', 'percentage_normal_customer_western', 'closed_customer_western', 'percentage_follow_customer_western', 'percentage_suspend_customer_western', 'percentage_closed_customer_western',
                'normal_customer_south', 'follow_customer_south','suspend_customer_south', 'percentage_normal_customer_south', 'percentage_follow_customer_south', 'closed_customer_south', 'percentage_suspend_customer_south', 'percentage_closed_customer_south',
                'customer_all', 'count_status_normal', 'count_status_follow', 'count_status_suspend', 'count_status_closed',
                'status_waiting', 'status_updated', 'status_alert', 'status_registration', 'user_id_admin'
                    
                
                ));
        // dd($customer_north);
    }
}
