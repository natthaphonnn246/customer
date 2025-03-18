<?php

namespace App\Http\Controllers\Webpanel;

use Illuminate\Http\Request;
use App\Models\Salearea;
use App\Models\Customer;
use App\Models\user;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WebpanelAdminController extends Controller
{
   /*  public function dashboard()
    {
        return view('webpanel/dashboard-admin');
    } */

    //dashboard;
    public function dashboard(Request $request)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];
        // dd('test');
        $customer_north = Customer::where('geography', 'ภาคเหนือ')->whereNotIn('customer_id',$code_notin)->count();
        $customer_central = Customer::where('geography', 'ภาคกลาง')->whereNotIn('customer_id',$code_notin)->count();
        $customer_eastern = Customer::where('geography', 'ภาคตะวันออก')->whereNotIn('customer_id',$code_notin)->count();
        $customer_northeast = Customer::where('geography', 'ภาคตะวันออกเฉียงเหนือ')->whereNotIn('customer_id',$code_notin)->count();
        $customer_western = Customer::where('geography', 'ภาคตะวันตก')->whereNotIn('customer_id',$code_notin)->count();
        $customer_south = Customer::where('geography', 'ภาคใต้')->whereNotIn('customer_id',$code_notin)->count();

        //ร้านค้าทั้งหมด;
        $customer_all = Customer::all()->whereNotIn('customer_id',$code_notin)->count();
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
        $normal_customer_north = Customer::where('status_user', '')->where('geography', 'ภาคเหนือ')->whereNotIn('customer_id',$code_notin)->count();
        $follow_customer_north = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคเหนือ')->whereNotIn('customer_id',$code_notin)->count();
        $suspend_customer_north = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคเหนือ')->whereNotIn('customer_id',$code_notin)->count();
        $closed_customer_north = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคเหนือ')->whereNotIn('customer_id',$code_notin)->count();
        // dd($closed_customer_north);
        // dd($suspend_customer_north);

        //percentage of status_customer_north;
        $percentage_normal_customer_north = ($normal_customer_north / $customer_north) * 100;
        $percentage_follow_customer_north = ($follow_customer_north / $customer_north) * 100;
        $percentage_suspend_customer_north = ($suspend_customer_north / $customer_north) * 100;
        $percentage_closed_customer_north = ($closed_customer_north / $customer_north) * 100;
        // dd($percentage_normal_customer_north);

         //status_user_central;
         $normal_customer_central = Customer::where('status_user', '')->where('geography', 'ภาคกลาง')->whereNotIn('customer_id',$code_notin)->count();
         $follow_customer_central = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคกลาง')->whereNotIn('customer_id',$code_notin)->count();
         $suspend_customer_central = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคกลาง')->whereNotIn('customer_id',$code_notin)->count();
         $closed_customer_central = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคกลาง')->whereNotIn('customer_id',$code_notin)->count();
         // dd($suspend_customer_central);

         //percentage of status_customer_central;
         $percentage_normal_customer_central = ($normal_customer_central / $customer_central) * 100;
         $percentage_follow_customer_central = ($follow_customer_central / $customer_central) * 100;
         $percentage_suspend_customer_central = ($suspend_customer_central / $customer_central) * 100;
         $percentage_closed_customer_central = ($closed_customer_central / $customer_central) * 100;
         // dd($percentage_normal_customer_central);

        //status_user_eastern;
        $normal_customer_eastern = Customer::where('status_user', '')->where('geography', 'ภาคตะวันออก')->whereNotIn('customer_id',$code_notin)->count();
        $follow_customer_eastern = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคตะวันออก')->whereNotIn('customer_id',$code_notin)->count();
        $suspend_customer_eastern = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคตะวันออก')->whereNotIn('customer_id',$code_notin)->count();
        $closed_customer_eastern = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคตะวันออก')->whereNotIn('customer_id',$code_notin)->count();
        // dd($suspend_customer_central);

        //percentage of status_customer_central;
        $percentage_normal_customer_eastern = ($normal_customer_eastern / $customer_eastern) * 100;
        $percentage_follow_customer_eastern = ($follow_customer_eastern / $customer_eastern) * 100;
        $percentage_suspend_customer_eastern = ($suspend_customer_eastern / $customer_eastern) * 100;
        $percentage_closed_customer_eastern = ($closed_customer_eastern / $customer_eastern) * 100;
        // dd($percentage_normal_customer_central);

         //status_user_northeast;
         $normal_customer_northeast = Customer::where('status_user', '')->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->whereNotIn('customer_id',$code_notin)->count();
         $follow_customer_northeast = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->whereNotIn('customer_id',$code_notin)->count();
         $suspend_customer_northeast = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->whereNotIn('customer_id',$code_notin)->count();
         $closed_customer_northeast = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->whereNotIn('customer_id',$code_notin)->count();
         // dd($suspend_customer_central);

         //percentage of status_customer_northeast;
         $percentage_normal_customer_northeast = ($normal_customer_northeast / $customer_northeast) * 100;
         $percentage_follow_customer_northeast = ($follow_customer_northeast / $customer_northeast) * 100;
         $percentage_suspend_customer_northeast = ($suspend_customer_northeast / $customer_northeast) * 100;
         $percentage_closed_customer_northeast = ($closed_customer_northeast / $customer_northeast) * 100;

         // dd($percentage_normal_customer_northeast);

          //status_user_western;
          $normal_customer_western = Customer::where('status_user', '')->where('geography', 'ภาคตะวันตก')->whereNotIn('customer_id',$code_notin)->count();
          $follow_customer_western = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคตะวันตก')->whereNotIn('customer_id',$code_notin)->count();
          $suspend_customer_western = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคตะวันตก')->whereNotIn('customer_id',$code_notin)->count();
          $closed_customer_western = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคตะวันตก')->whereNotIn('customer_id',$code_notin)->count();
          // dd($suspend_customer_central);

          //percentage of status_customer_western;
          $percentage_normal_customer_western = ($normal_customer_western / $customer_western) * 100;
          $percentage_follow_customer_western = ($follow_customer_western / $customer_western) * 100;
          $percentage_suspend_customer_western = ($suspend_customer_western / $customer_western) * 100;
          $percentage_closed_customer_western = ($closed_customer_western / $customer_western) * 100;
          // dd($percentage_normal_customer_western);

           //status_user_south;
           $normal_customer_south = Customer::where('status_user', '')->where('geography', 'ภาคใต้')->whereNotIn('customer_id',$code_notin)->count();
           $follow_customer_south = Customer::where('status_user', 'กำลังติดตาม')->where('geography', 'ภาคใต้')->whereNotIn('customer_id',$code_notin)->count();
           $suspend_customer_south = Customer::where('status_user', 'ถูกระงับสมาชิก')->where('geography', 'ภาคใต้')->whereNotIn('customer_id',$code_notin)->count();
           $closed_customer_south = Customer::whereNotIn('status_user', ['', 'กำลังติดตาม', 'ถูกระงับสมาชิก'])->where('geography', 'ภาคใต้')->whereNotIn('customer_id',$code_notin)->count();
           // dd($suspend_customer_central);

           //percentage of status_customer_south;
           $percentage_normal_customer_south = ($normal_customer_south / $customer_south) * 100;
           $percentage_follow_customer_south = ($follow_customer_south / $customer_south) * 100;
           $percentage_suspend_customer_south = ($suspend_customer_south / $customer_south) * 100;
           $percentage_closed_customer_south = ($closed_customer_south / $customer_south) * 100;
           // dd($percentage_normal_customer_south);


           //status_normal;
           $count_status_normal = Customer::where('status_user', '')->whereNotIn('customer_id',$code_notin)->count();
           //status_follow;
           $count_status_follow = Customer::where('status_user', 'กำลังติดตาม')->whereNotIn('customer_id',$code_notin)->count();
           //status_suspend;
           $count_status_suspend = Customer::where('status_user', 'ถูกระงับสมาชิก')->whereNotIn('customer_id',$code_notin)->count();
           //status_closed;
           $count_status_closed = Customer::whereNotIn('status_user', ['','กำลังติดตาม','ถูกระงับสมาชิก'])->whereNotIn('customer_id',$code_notin)->count();

           //menu alert;
           $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_id',$code_notin)
                                        ->count();

            $status_updated = Customer::where('status_update', 'updated')
                                        ->whereNotIn('customer_id',$code_notin)
                                        ->count();

            $status_alert = $status_waiting + $status_updated;

        // dd($customer_view);

        // $row_arr = [$customer_north, $customer_central, $customer_eastern, $customer_northeast, $customer_western, $customer_south];

        $user_name = $request->user()->name;
        // $admin_name = User::where('user_name', )
        return view('admin/dashboard-admin',

        compact('customer_north' , 'customer_central', 'customer_eastern', 'customer_northeast', 'customer_western', 'customer_south',
                'percentage_north', 'percentage_central', 'percentage_eastern', 'percentage_northeast', 'percentage_western', 'percentage_south',
                'normal_customer_north', 'follow_customer_north','suspend_customer_north','closed_customer_north', 'percentage_normal_customer_north', 'percentage_follow_customer_north', 'percentage_suspend_customer_north', 'percentage_closed_customer_north',
                'normal_customer_central', 'follow_customer_central','suspend_customer_central','closed_customer_central', 'percentage_normal_customer_central', 'percentage_follow_customer_central', 'percentage_suspend_customer_central','percentage_closed_customer_central',
                'normal_customer_eastern', 'follow_customer_eastern','suspend_customer_eastern','closed_customer_eastern', 'percentage_normal_customer_eastern', 'percentage_follow_customer_eastern', 'percentage_suspend_customer_eastern', 'percentage_closed_customer_eastern',
                'normal_customer_northeast', 'follow_customer_northeast','suspend_customer_northeast', 'closed_customer_northeast', 'percentage_normal_customer_northeast', 'percentage_follow_customer_northeast', 'percentage_suspend_customer_northeast', 'percentage_closed_customer_northeast',
                'normal_customer_western', 'follow_customer_western','suspend_customer_western', 'percentage_normal_customer_western', 'closed_customer_western', 'percentage_follow_customer_western', 'percentage_suspend_customer_western', 'percentage_closed_customer_western',
                'normal_customer_south', 'follow_customer_south','suspend_customer_south', 'percentage_normal_customer_south', 'percentage_follow_customer_south', 'closed_customer_south', 'percentage_suspend_customer_south', 'percentage_closed_customer_south',
                'customer_all', 'count_status_normal', 'count_status_follow', 'count_status_suspend', 'count_status_closed',
                'status_waiting', 'status_updated', 'status_alert', 'user_name'


                ));
        // dd($customer_north);
    }
    public function indexCustomer(Request $request): View
    {

        @$page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        $user_name = $request->user()->name;

        //แสดงข้อมูลลูกค้า;
        $row_customer = Customer::viewCustomer($page);
        $customer = $row_customer[0];
        $start = $row_customer[1];
        $total_page = $row_customer[2];
        $page = $row_customer[3];

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        //Dashborad;
        // $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
        $total_customer = Customer::whereNotIn('customer_code', $code_notin)->count();
        $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', $code_notin)->count();
        $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', $code_notin)->count();

        //เพิ่มลูกค้า;
        // $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //dropdown admin_area;
        $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
        ////////////////////////////////////////////////////////

        $keyword_search = $request->keyword;
        // dd($keyword);

        $user_name = $request->user()->name;

        if($keyword_search != '') {

            $count_page = Customer::where('customer_id', 'Like', "%{$keyword_search}%")
                                    ->whereNotIn('customer_id',$code_notin)
                                    ->count();
            // dd($count_page);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            // $customer = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
            $customer = Customer::whereNotIn('customer_id', $code_notin)
                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                    ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            // $check_keyword = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
            $check_keyword = Customer::whereNotIn('customer_id', $code_notin)
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                        ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                        ->get();

            // dd($check_customer_code);

            // dd($check_search->admin_area);
            if(!$check_keyword  == null) {
                return view('admin/customer', compact('count_page', 'check_keyword', 'admin_area', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                            'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated', 'user_name'));

            }

                // return back();

        }

        $count_page = 1;
        return view('admin/customer', compact('count_page', 'admin_area', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated', 'user_name'));

    }

    public function edit(Request $request, $id)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $customer_edit = Customer::customerEdit($id);
        $customer_view = $customer_edit[0];

        $admin_area_list  = User::select('admin_area', 'name', 'rights_area')->get();

        $admin_area_check = Customer::select('admin_area', 'customer_id')->where('id', $id)->first();
        // dd($admin_area_check->customer_id);

        $sale_area = Salearea::select('sale_area', 'sale_name')
                    ->orderBy('sale_area' ,'asc')
                    ->get();

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;


        //user_name admin;
        $user_name = $request->user()->name;

        return view('admin/customer-detail', compact('customer_view', 'province', 'amphur', 'district', 'admin_area_list', 'admin_area_check', 'sale_area', 'status_waiting', 'status_alert', 'status_updated', 'user_name'));
    }

    public function indexStatus(Request $request, $status_check): View
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        //user_name admin;
        $user_name = $request->user()->name;

        //menu alert;
        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //แสดงข้อมูลลูกค้า;

        if($status_check == 'waiting') {

            $row_customer = Customer::customerWaiting($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            // $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_customer = Customer::whereNotIn('customer_code', $code_notin)->count();
            // $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();

            return view('admin/customer-waiting', compact('user_name', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting', 'status_waiting', 'status_updated', 'status_alert'));

        } else if ($status_check == 'action') {

            $row_customer = Customer::customerAction($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            // $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_customer = Customer::whereNotIn('customer_code', $code_notin)->count();
            // $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();

            return view('admin/customer-action', compact('user_name', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_action', 'status_waiting', 'status_updated', 'status_alert'));

        } else if ($status_check == 'completed') {

            $row_customer = Customer::customerCompleted($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            // $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_customer = Customer::whereNotIn('customer_code', $code_notin)->count();
            // $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', $code_notin)->count();

            return view('admin/customer-completed', compact('user_name', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_completed', 'status_waiting', 'status_updated', 'status_alert'));
        } else if ($status_check == 'latest_update') {

            $row_customer = Customer::latestUpdate($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            // $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_customer = Customer::whereNotIn('customer_code', $code_notin)->count();
            // $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', $code_notin)->count();

            return view('admin/customer-updatelatest', compact('user_name', 'customer', 'start', 'total_page', 'page', 'total_customer','total_status_updated', 'status_waiting', 'status_updated', 'status_alert'));

        } else if ($status_check == 'inactive') {

            $row_customer = Customer::customerInactive($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            // $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_customer = Customer::whereNotIn('customer_code', $code_notin)->count();
            // $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count();
            $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', $code_notin)->count();

            return view('admin/customer-inactive', compact('user_name', 'customer', 'start', 'total_page', 'page', 'total_customer', 'customer_status_inactive', 'status_waiting', 'status_updated', 'status_alert'));

        } else if ($status_check == 'following') {

            $row_customer = Customer::customerFollowing($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            // $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_customer = Customer::whereNotIn('customer_code', $code_notin)->count();
            // $customer_status_following = Customer::where('status_user', 'กำลังติดตาม')->whereNotIn('customer_code', ['0000','4494'])->count();
            $customer_status_following = Customer::where('status_user', 'กำลังติดตาม')->whereNotIn('customer_code', $code_notin)->count();

            return view('admin/customer-following', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'customer_status_following', 'status_waiting', 'status_updated', 'status_alert', 'user_name'));

        }

        else {
            return abort(403, 'Error requesting');
        }

    }

    public function indexAdminArea(Request $request, $admin_id)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        // dd($request->status);
        // dd($status);
        $admin_area = User::where('admin_area', $admin_id)->first();

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }
        $user_name = $request->user()->name;

          //menu alert;
        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //แสดงข้อมูลลูกค้า;
        $row_customer = Customer::viewCustomerAdminArea($page, $admin_id);
        $customer = $row_customer[0];
        $start = $row_customer[1];
        $total_page = $row_customer[2];
        $page = $row_customer[3];

        // name;
        $admin_name = User::select('admin_area', 'name')->where('admin_area', $admin_id)->first();

        //Dashborad;
        // $total_customer_adminarea = Customer::whereNotIn('customer_code', ['0000','4494'])->where('admin_area', $admin_id)->count();
        // $total_status_waiting = Customer::where('admin_area', $admin_id)->where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        // $total_status_action = Customer::where('admin_area', $admin_id)->where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        // $total_status_completed = Customer::where('admin_area', $admin_id)->where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();

        $total_customer_adminarea = Customer::whereNotIn('customer_code', $code_notin)->where('admin_area', $admin_id)->count();
        $total_status_waiting = Customer::where('admin_area', $admin_id)->where('status', 'รอดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_action = Customer::where('admin_area', $admin_id)->where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_completed = Customer::where('admin_area', $admin_id)->where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', $code_notin)->count();

            //dropdown admin_area;
            $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
            ////////////////////////////////////////////////////////

            $keyword_search = $request->keyword;
            // dd($keyword);

            // dd($request->status);
        switch ($request->status)
        {
            case 'status-waiting':

            $row_customer = Customer::viewCustomerAdminAreaWaiting($page, $admin_id);
            $customer = $row_customer[0];
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            if($keyword_search != '') {

                    $count_page = Customer::where('status','รอดำเนินการ')
                                            ->where('admin_area', $admin_id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                    // dd(($count_page));

                    $perpage = 10;
                    $total_page = ceil($count_page / $perpage);
                    $start = ($perpage * $page) - $perpage;

                    $customer = Customer::where('status','รอดำเนินการ')
                                            ->where('admin_area', $admin_id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();

                    $check_keyword = Customer::where('status','รอดำเนินการ')
                                                ->where('admin_area', $admin_id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                ->get();

                    // dd($check_customer_code);

                    // dd($check_search->admin_area);
                    if(!$check_keyword  == null) {
                        return view('admin/adminarea-waiting',compact('user_name', 'check_keyword','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));

                    }

                        return back();

            }
            $count_page = 1;
            return view('admin/adminarea-waiting' ,compact('user_name', 'admin_name','count_page', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
            break;

            case 'status-action':

                $row_customer = Customer::viewCustomerAdminAreaAction($page, $admin_id);
                $customer = $row_customer[0];
                $start = $row_customer[1];
                $total_page = $row_customer[2];
                $page = $row_customer[3];
                $count_page_master = $row_customer[4];

                // dd($count_page_master);
                if($keyword_search != '') {

                        $count_page = Customer::where('status','ต้องดำเนินการ')
                                                ->where('admin_area', $admin_id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                        // dd(gettype($count_page));

                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        $start = ($perpage * $page) - $perpage;

                        $customer = Customer::where('status','ต้องดำเนินการ')
                                                ->where('admin_area', $admin_id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                ->offset($start)
                                                ->limit($perpage)
                                                ->get();

                        $check_keyword = Customer::where('status','ต้องดำเนินการ')
                                                    ->where('admin_area', $admin_id)
                                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->whereNotIn('customer_id', $code_notin)
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                    // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                    ->get();

                        // dd($check_customer_code);

                        // dd($check_search->admin_area);
                        if(!$check_keyword  == null) {
                            return view('admin/adminarea-action',compact('user_name', 'check_keyword','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));

                        }

                            return back();

                }
                $count_page = 1;
                return view('admin/adminarea-action' ,compact('user_name', 'count_page_master','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
                break;

                case 'status-completed':

                    $row_customer = Customer::viewCustomerAdminAreaCompleted($page, $admin_id);
                    $customer = $row_customer[0];
                    $start = $row_customer[1];
                    $total_page = $row_customer[2];
                    $page = $row_customer[3];

                    if($keyword_search != '') {

                            $count_page = Customer::where('status','ดำเนินการแล้ว')
                                                    ->where('admin_area', $admin_id)
                                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->whereNotIn('customer_id', $code_notin)
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                            // dd(gettype($count_page));

                            $perpage = 10;
                            $total_page = ceil($count_page / $perpage);
                            $start = ($perpage * $page) - $perpage;

                            $customer = Customer::where('status','ดำเนินการแล้ว')
                                                    ->where('admin_area', $admin_id)
                                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->whereNotIn('customer_id', $code_notin)
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                    // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();

                            $check_keyword = Customer::where('status','ดำเนินการแล้ว')
                                                        ->where('admin_area', $admin_id)
                                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                        ->whereNotIn('customer_id', $code_notin)
                                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                        // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                        ->get();

                            // dd($check_customer_code);

                            // dd($check_search->admin_area);
                            if(!$check_keyword  == null) {
                                return view('admin/adminarea-completed',compact('user_name', 'check_keyword','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));

                            }

                                return back();

                    }
                    $count_page = 1;
                    return view('admin/adminarea-completed' ,compact('user_name', 'admin_name','count_page', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
                    break;


            //customer/adminarea;
            default:

                if($keyword_search != '') {

                        $count_page = Customer::where('admin_area', $admin_id)
                                                ->whereNotIn('customer_id',$code_notin)
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                        // dd(gettype($count_page));

                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        $start = ($perpage * $page) - $perpage;

                        $customer = Customer::where('admin_area', $admin_id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();

                        // $check_keyword = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                        $check_keyword = Customer::whereNotIn('customer_id', $code_notin)
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                    // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                    ->get();

                        // dd($check_customer_code);

                        // dd($check_search->admin_area);
                        if(!$check_keyword  == null) {
                            return view('admin/adminarea-detail',compact('user_name', 'check_keyword','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));

                        }

                            return back();

                }
                $count_page = 1;
                return view('admin/adminarea-detail',compact('user_name', 'admin_name','count_page', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
        }

    }
}
