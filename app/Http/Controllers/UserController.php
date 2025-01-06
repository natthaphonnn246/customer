<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

Class UserController
{
    
    public function create(Request $request)
    {
       //timestamp;
    date_default_timezone_set("Asia/Bangkok");
    
            if (isset($request['submit_form']) != '')
            {
                $code = $request->code;
                $name = $request->admin_name;
                $role = $request->role;
                $email = $request->email;
                $password = $request->password;
                $telephone = $request->telephone;
                $address = $request->address;
                $province = $request->province;
                $amphur = $request->amphur;
                $district = $request->district;
                $zipcode = $request->zipcode;
                $email_login = $request->email_login;
                $text_add = $request['text_add'];
                
               /*  if($request->text_add == '') {
                    $text_add = '';
                } else {
                    $text_add = $request->text_add;
                } */
            }

                $province_master = DB::table('provinces')->select('id', 'name_th')->where('id', $province)->first();
                $province_row = $province_master->name_th;

                User::create([

                                'user_code' => $code,
                                'user_id' => $code,
                                'admin_area' => '',
                                'name' => $name,
                                'role' => $role,
                                'status_checked' => '',
                                'email' => $email,
                                'password' => $password,
                                'telephone' => $telephone,
                                'address' => $address,
                                'province' => $province_row,
                                'amphur' => $amphur,
                                'district' => $district,
                                'zipcode' => $zipcode,
                                'email_login' => $email_login,
                                'text_add' => $text_add,

                            ]);

                Admin::create([

                                'admin_name' => $name,
                                'admin_id' => $code,
                                'code' => $code,
                                'admin_area' => '',
                                'role' => $role,
                                'status_checked' => '',
                                'email' => $email,
                                'telephone' => $telephone,
                                'address' => $address,
                                'province' => $province_row,
                                'amphur' => $amphur,
                                'district' => $district,
                                'zipcode' => $zipcode,
                                'email_login' => $email_login,
                                'password' => $password,
                                'text_add' => $text_add,
                        
                            ]);

                    $check_tb = User::select('user_code')->where('user_code', $code)->first();
                    $check_code = $check_tb->user_code;

                    if($code == $check_code) {

                        return redirect('/webpanel/admin');
                    } else {
                            
                        return view('/webpanel/admin-create');
                    } 
    }
    public function admin()
    {
        return view('webpanel/dashboard');
    }
    public function portalSignin(Request $request)
    {
        
        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;
        
        $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->get();
        $admin_area = DB::table('customers')->select('admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at')->whereIn('admin_area', [$id])->get();
  
        return view('portal/customer', compact('admin_area', 'user_name'));
    }

    public function statusAct(Request $request)
    {
        if($request->id == 2 && $request->status == 'active')
        {
            $user_code = $request->user_code;
    
            User::where('user_code', [$user_code])
                ->update(['status_checked' => 'active']);

            echo "success".$user_code;
        }

    }

    public function statusiAct(Request $request)
    {
        if($request->id == 1 && $request->status_in == 'inactive')
        {
            $user_code = $request->user_code;

            User::where('user_code', [$user_code])
                ->update(['status_checked' => 'inactive']);

            echo "inactive";
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

    public function userData()
    {
        $row_user = User::user();
        $user_master = $row_user[0];
        return view('webpanel/admin', compact('user_master'));
    }

    public function edit($id)
    {
        $master = User::adminEdit($id);
        $admin_row = $master[0];

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        return view('webpanel/admin-detail', compact('admin_row', 'province', 'amphur', 'district'));
    }

    public function update(Request $request, $id)
    {

            date_default_timezone_set("Asia/Bangkok");

                $admin_area = $request['admin_area'];
                $name = $request->admin_name;
                $role = $request->role;
                $rights_area = $request->rights_area;
                $email = $request->email;
                $telephone = $request->telephone;
                $address = $request->address;
                $province = $request->province;
                $amphur_post = $request->amphur;
                $district_post = $request->district;
                $zipcode_post = $request->zipcode;
                $email_login = $request->email_login;
                $text_add = $request['text_add'];

                $update_time = date('Y-m-d H:i:s');

                $province_master = DB::table('provinces')->select('id', 'name_th')->where('id', $province)->first();
                $province_row = $province_master->name_th;

            DB::table('users')
                ->where('user_code', $id)
                ->update
                ([

                    /* 'user_code' => $code,
                    'user_id' => $code, */
                    'name' => $name,
                    'role' => $role,
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
                
                ]);

            DB::table('user_tb')
                ->where('admin_id', $id)
                ->update
                ([

                    // 'admin_id' => $code,
                    'admin_area' => $admin_area,
                    'admin_name' => $name,
                    'role' => $role,
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
                
                ]);
                // check user id;
                $check_user_id = User::select('user_id')->where('user_id', $id)->first();
                $user_id = $check_user_id->user_id;

                if ($user_id == $id) {
                    echo 'success';

                } else {
                    echo 'fail';
                }
    }
    
    public function reset(Request $request, $id_reset)
    {
        if(isset($request['submit_reset']) != '')
        {
            $password = $request->reset_password;

            $check_code_pass = User::select('user_code')->where('user_code',$id_reset)->first();
            $check_id = $check_code_pass->user_code;

            if($check_id == $id_reset)
            {
                    DB::table('users')
                        ->where('user_code', [$id_reset])
                        ->update(['password' => bcrypt($password)]);


                    DB::table('user_tb')
                        ->where('code', [$id_reset])
                        ->update(['password' => $password]);

                    return back()->with('success', 'เปลี่ยนรหัสผ่านสำเร็จ');

            } else {
                
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }
        }
    }

}