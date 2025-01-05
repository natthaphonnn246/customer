<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

Class UserController
{
    
    public function create()
    {
       //timestamp;
       date_default_timezone_set("Asia/Bangkok");
        
       if (isset($_POST['submit_form']) != '')
        {
           $code = $_POST['code'];
           $name = $_POST['admin_name'];
           $role = $_POST['role'];
           $status_checked = 'inactive';
           $email = $_POST['email'];
           $password = ($_POST['password']);
           $telephone = $_POST['telephone'];
           $address = $_POST['address'];
           $province = $_POST['province'];
           $amphur = $_POST['amphur'];
           $district = $_POST['district'];
           $zipcode = $_POST['zipcode'];
           $email_login = $_POST['email_login'];
           $text_add = $_POST['text_add'];

           $province_master = DB::table('provinces')->select('id', 'name_th')->whereIn('id', [$province])->get();
           foreach ($province_master as $row)
           {
               $province_row = $row->name_th;
           }

           $user = User::create([

                       'user_code' => $code,
                       'user_id' => $code,
                       'admin_area' => '',
                       'name' => $name,
                       'role' => $role,
                       'status_checked' => $status_checked,
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

           $admins = Admin::create([

                        'admin_name' => $name,
                        'admin_id' => $code,
                        'code' => $code,
                        'admin_area' => '',
                        'role' => $role,
                        'status_checked' => $status_checked,
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
        }
       
           $check_tb = DB::table('users')->select('user_code')->get();
           foreach ($check_tb as $row)
           {
               $check_code = $row->user_code;
           }

           if($code == $check_code)
               {
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
        // test
        $code = $request->user()->user_code;
        
        $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->get();
        $admin_area = DB::table('customers')->select('admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at')->whereIn('admin_area', [$id])->get();
  
        return view('portal/customer', compact('admin_area', 'user_name'));
    }

    public function statusAct()
    {
        if(isset($_POST['id']) == 2 && $_POST['status'] == 'active')
        {
            $user_code = $_POST['user_code'];
            //your database query here
            DB::table('users')
            ->where('user_code', [$user_code])
            ->update(['status_checked' => 'active']);
            echo "success".$user_code;
        }

    }

    public function statusiAct()
    {
        if(isset($_POST['id']) == 1 && $_POST['status_in'] == 'inactive')
        {
            $user_code = $_POST['user_code'];
            //your database query here
            DB::table('users')
            ->where('user_code', [$user_code])
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

    public function update($id)
    {
            date_default_timezone_set("Asia/Bangkok");

            $admin_area = $_POST['admin_area'];
            $name = $_POST['admin_name'];
            $role = $_POST['role'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $address = $_POST['address'];
            $province = $_POST['province'];
            $amphur_post = $_POST['amphur'];
            $district_post = $_POST['district'];
            $zipcode_post = $_POST['zipcode'];
            $email_login = $_POST['email_login'];
            $text_add = $_POST['text_add'];

            $update_time = date('Y-m-d H:i:s');

            $province_master = DB::table('provinces')->select('id', 'name_th')->whereIn('id', [$province])->get();
            foreach ($province_master as $row)
            {
                $province_row = $row->name_th;
            }
          

            DB::table('users')
                ->where('user_code', [$id])
                ->update
                ([

                    /* 'user_code' => $code,
                    'user_id' => $code, */
                    'name' => $name,
                    'role' => $role,
                    'admin_area' => $admin_area,
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
                ->where('admin_id', [$id])
                ->update
                ([

                    // 'admin_id' => $code,
                    'admin_area' => $admin_area,
                    'admin_name' => $name,
                    'role' => $role,
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
                $check_user_id = DB::table('users')->select('user_id')->whereIn('user_id', [$id])->get();
                foreach ($check_user_id as $row)
                {
                    $user_id = $row->user_id;
                }
                if ($user_id == $id)
                {
                    echo 'success';
                } else {
                    echo 'fail';
                }


    }
    
    public function reset($id_reset)
    {
        if(isset($_POST['submit_reset']) != '')
        {
            $password = $_POST['reset_password'];

            $check_code_pass = DB::table('users')->select('user_code', 'password')->whereIn('user_code',[$id_reset])->get();
            foreach ($check_code_pass as $row_pass)
            {
                $check_id = $row_pass->user_code;
                $check_password = $row_pass->password;
            }
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