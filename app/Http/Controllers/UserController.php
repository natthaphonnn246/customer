<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\ProductType;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Process\Exceptions\ProcessFailedException;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Sleep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


Class UserController
{
    
    public function create(Request $request)
    {
        
       //timestamp;
    date_default_timezone_set("Asia/Bangkok");
    
            if ($request->has('submit_form') == true)
            {
                $code = $request->code;
                $name = $request->admin_name;
                $role = $request->role;
                // $admin_role = $request->admin_role;
                $email = $request->email;
                $password = $request->password;
                $address = $request->address;
                $province = $request->province;
                $amphur = $request->amphur;
                $district = $request->district;
                $zipcode = $request->zipcode;
                $email_login = $request->email_login;

                $text_add = $request->text_add;
                if($request->text_add == null) {
                    $text_add = '';

                } 

                $telephone = $request->telephone;
                if($request->telephone == null) {
                    $telephone = '';

                } 
            }

                $province_master = DB::table('provinces')->select('id', 'name_th')->where('id', $province)->first();
                $province_row = $province_master->name_th;

                $user_email = User::select('email')->where('email', $email)->first();
                $check_email = $user_email?->email;


                $check_tb = User::select('user_code')->where('user_code', $code)->first();
                $check_code = $check_tb?->user_code;

                if($email != $check_email && $code != $check_code)
                {
                            User::create([

                                            'user_code' => $code,
                                            'user_id' => $code,
                                            'admin_area' => '',
                                            'name' => $name,
                                            'role' => $role,
                                            // 'admin_role' => $admin_role,
                                            'status_checked' => '',
                                            'email' => $email,
                                            // 'password' => $password,
                                            'password' => Hash::make($password),
                                            'telephone' => $telephone,
                                            'address' => $address ?? '',
                                            'province' => $province_row,
                                            'amphur' => $amphur,
                                            'district' => $district,
                                            'zipcode' => $zipcode,
                                            'email_login' => $email_login,
                                            'text_add' => $text_add,
                                        /*  'maintenance_status' => '0',
                                            'allowed_maintenance_status' => '0', */
                                            'allowed_user_status' => '0',
                                            'check_login' => '',
                                            'login_date'      => '',
                                            'last_activity'   => '',
                                            'purchase_status' => '0',
                                            'allowed_check_type' => '0',

                                        ]);

                            Admin::create([

                                            'admin_name' => $name,
                                            'admin_id' => $code,
                                            'code' => $code,
                                            'admin_area' => '',
                                            'role' => $role,
                                            // 'admin_role' => $admin_role,
                                            'status_checked' => '',
                                            'email' => $email,
                                            'telephone' => $telephone,
                                            'address' => $address ?? '',
                                            'province' => $province_row,
                                            'amphur' => $amphur,
                                            'district' => $district,
                                            'zipcode' => $zipcode,
                                            'email_login' => $email_login,
                                            'password' => $password,
                                            'text_add' => $text_add,
                                        /*  'maintenance_status' => '0',
                                            'allowed_maintenance_status' => '0', */
                                            'allowed_user_status' => '0',
                                            'check_login' => '',
                                            'login_date' => '',
                                            'last_activity' => '',
                                    
                                        ]);

                return redirect('/webpanel/admin');

                } else {

                    return redirect('/webpanel/admin-create')->with('error_admin', 'email');
                }

               /*  if($code == $check_code) {

                    return redirect('/webpanel/admin');
                } else {
                        
                    return view('/webpanel/admin-create');
                }  */
    }
    public function admin()
    {
        return view('webpanel/dashboard');
    }
    /* public function portalSignin(Request $request)
    {
        
        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;
        
        $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->get();
        $admin_area = DB::table('customers')->select('admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at')->whereIn('admin_area', [$id])->get();
  
        return view('portal/customer', compact('admin_area', 'user_name'));
    } */

    public function statusAct(Request $request)
    {
        if($request->id_act == 2 && $request->status == 'active' && $request->is_blocked == 0)
        {
            $code_id = $request->code_id;
    
            User::where('id', [$code_id])
                ->update(['status_checked' => 'active',
                        'is_blocked' => 0,
                        ]);

            echo "success".$code_id;
        }

    }

    public function statusiAct(Request $request)
    {
        if($request->id_inact == 1 && $request->status_in == 'inactive' && $request->is_blocked == 1)
        {
            $code_id = $request->code_id;

            User::where('id', [$code_id])
                ->update(['status_checked' => 'inactive',
                'is_blocked' => 1,
                ]);

            echo "inactive";
        }

    }

    public function isBlocked(Request $request)
    {
        if($request->is_blocked == 1)
        {
            $code_id = $request->code_blocked;
    
            $user = User::where('id', $code_id)->first();
            $user->is_blocked = 1;
            $user->save();

            echo "isblocked";
        }

    }

    public function unBlocked(Request $request)
    {
        if($request->is_blocked == 0)
        {
            $code_id = $request->code_blocked;
    
            $user = User::where('id', $code_id)->first();
            $user->is_blocked = 0;
            $user->save();

            echo "unblocked";
        }

    }
   /*  public function adminCheck()
    {
        @$user_code = $_POST['user_code'];
        $status = DB::table('users')->select('status_checked')->where('user_code', '=', $user_code)->get();
        foreach($status as $row)
        {
            $status_admin = $row->status_checked;
            
        }
        return view('webpanel/admin', compact('status_admin'));
    } */

    public function userData(Request $request)
    {


 /*    $response = Http::connectTimeout(4)->get('http://127.0.0.1:8000/');
    $date_update = date_default_timezone_set("Asia/Bangkok"); */
    // dd($ipAddresses = $request->ips());
    /* $now = now();
    dd($now); */
 /*    $result = Process::timeout(30)->run('bash import.sh');
    dd($result); */

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $row_user = User::user();
        $user_master = $row_user[0];

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('webpanel/admin', compact('user_master', 'status_waiting', 'status_updated','status_registration', 'status_alert', 'user_id_admin'));
    }

    public function edit(Request $request, $id)
    {
        $admin_master = User::adminEdit($id);
        // $admin_row = $master[0];

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();


        $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                ->whereNotIn('customer_id',$code_notin)
                                ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        $count_check_login = User::select('check_login')->where('id',$id)->first();

        $check_user_id = User::find($id)?->user_id;
        // dd($check_user_id);

        $count_check_type = ProductType::where('user_id', $check_user_id)->count();
        // dd($count_check_type);
        // dd($count_check_login->check_login);

        return view('webpanel/admin-detail', compact(
                                                        'admin_master', 
                                                        'province', 
                                                        'amphur', 
                                                        'district', 
                                                        'status_alert',
                                                        'status_registration', 
                                                        'status_waiting', 
                                                        'status_updated', 
                                                        'user_id_admin', 
                                                        'count_check_login',
                                                        'count_check_type'
                                                    ));
    }

    public function update(Request $request, $id)
    {

            date_default_timezone_set("Asia/Bangkok");

                // $admin_area = $request['admin_area'];
                $admin_area = $request->admin_area;
                if($request->admin_area == null) {
                    $admin_area = '';
                }

                $user_code = $request->code;
                $name = $request->admin_name;
                $role = $request->role;
                $admin_role = $request->admin_role;
                $rights_area = $request->rights_area;
                $email = $request->email_login;
                $address = $request->address;
                $province = $request->province;
                $amphur_post = $request->amphur;
                $district_post = $request->district;
                $zipcode_post = $request->zipcode;
                $email_login = $request->email_login;
                // $text_add = $request['text_add'];

                $telephone = $request->telephone;
                if($request->telephone == null) {
                    $telephone = '';
                }
                $text_add = $request->text_add;
                if($request->text_add == null) {
                    $text_add = '';
                }

                $allowed_mtnance = $request->allowed_user_status;
                if($request->allowed_user_status == null) {
                    $allowed_mtnance = '0';
                }

                if($request->text_add == null) {
                    $text_add = '';
                }

                $purchase_status = $request->purchase_status;

                $update_time = date('Y-m-d H:i:s');

                $province_master = DB::table('provinces')->select('id', 'name_th')->where('id', $province)->first();
                $province_row = $province_master->name_th;
                $allowed_check_type = $request->allowed_check_type;

            DB::table('users')
                ->where('id', $id)
                ->update ([

                    'user_code' => $user_code,
                    'user_id' => $user_code,
                    'name' => $name,
                    'role' => $role,
                    'admin_role' => $admin_role,
                    'admin_area' => $admin_area,
                    'rights_area' => $rights_area,
                    'email' => $email,
                    'telephone' => $telephone,
                    'address' => $address,
                    'province' => $province_row,
                    'amphur' => $amphur_post,
                    'district' => $district_post,
                    'zipcode' => $zipcode_post,
                    'email_login' => $email_login,
                    'text_add' => $text_add,
                    'updated_at' => $update_time,
                    'allowed_user_status' => $allowed_mtnance,
                    'purchase_status' => $purchase_status,
                    'allowed_check_type' =>$allowed_check_type,
                
                ]);

            DB::table('user_tb')
                ->where('id', $id)
                ->update ([

                    'admin_id' => $user_code,
                    'code' => $user_code,
                    'admin_area' => $admin_area,
                    'admin_name' => $name,
                    'role' => $role,
                    // 'admin_role' => $admin_role,
                    'rights_area' => $rights_area,
                    'email' => $email,
                    'telephone' => $telephone,
                    'address' => $address,
                    'province' => $province_row,
                    'amphur' => $amphur_post,
                    'district' => $district_post,
                    'zipcode' => $zipcode_post,
                    'email_login' => $email_login,
                    'text_add' => $text_add,
                    'updated_at' => $update_time,
                    'allowed_user_status' => $allowed_mtnance,
                
                ]);
                usleep(200000);
                // check user id;
                $check_user_id = User::select('id')->where('id', $id)->first();
                $user_id = $check_user_id->id;

                if ($user_id == $id) {

                    // echo 'success';

                    return redirect('/webpanel/admin/'.$id)->with('status', 'updated_success');

                } else {

                    return redirect('/webpanel/admin/'.$id)->with('status', 'updated_fail');

                    // echo 'fail';
                }
    }
    
    public function reset(Request $request, $id_reset)
    {
        if(isset($request['submit_reset']) != '')
        {
            $password = $request->reset_password;

            $check_code_pass = User::select('id')->where('id',$id_reset)->first();
            $check_id = $check_code_pass->id;

            if($check_id == $id_reset)
            {
                    DB::table('users')
                        ->where('id', [$id_reset])
                        ->update(['password' => bcrypt($password)]);


                    DB::table('user_tb')
                        ->where('id', [$id_reset])
                        ->update(['password' => $password]);

                    return back()->with('success', 'เปลี่ยนรหัสผ่านสำเร็จ');

            } else {
                
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }
        }
    }

      //delete admin;
   public function deleteAdmin(Request $request,  $id)
   {

        if(!empty($request->id)) {

            // echo json_encode(array('checkcode'=> $request->user_code));

            $useradmin = User::where('id', $id)->first();

            $useradmin ->delete();

            echo json_encode(array('checkcode'=> $request->id));

        }
    
   }

}

/* 1893832645000
1742789132 */