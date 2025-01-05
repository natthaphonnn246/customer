<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //timestamp;
        date_default_timezone_set("Asia/Bangkok");
        
        if (isset($_POST['submit_form']) != '')
        {
            $admin_id = ($_POST['code']);
            $code = $_POST['code'];
            $name = $_POST['admin_name'];
            $role = $_POST['role'];
            $status_checked = 'inactive';
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $province = $_POST['province'];
            $amphur = $_POST['amphur'];
            $district = $_POST['district'];
            $zipcode = $_POST['zipcode'];
            $email_login = $_POST['email_login'];
            $password = ($_POST['password']);
            $text_add = $_POST['text_add'];

            $province_master = DB::table('provinces')->select('id', 'name_th')->whereIn('id', [$province])->get();
            foreach ($province_master as $row)
            {
                $province_row = $row->name_th;
            }

            $admins = Admin::create([

                        'admin_name' => $name,
                        'admin_id' => $admin_id,
                        'code' => $code,
                        'role' => $role,
                        'status_checked' => $status_checked,
                        'email' => $email,
                        'telephone' => $phone,
                        'address' => $address,
                        'province' => $province_row,
                        'amphur' => $amphur,
                        'district' => $district,
                        'zipcode' => $zipcode,
                        'email_login' => $email_login,
                        'password' => $password,
                        'text_add' => $text_add,
                 
            ]);

            $user = User::create([

                'user_code' => $code,
                'name' => $name,
                'role' => $role,
                'status_checked' => $status_checked,
                'email' => $email,
                'password' => $password,
                'text_add' => $text_add,

                   
            ]);
        }
        
            $check_tb = DB::table('admins')->select('admin_id')->get();
            foreach ($check_tb as $row)
            {
                $check_id = $row->admin_id;
            }

            if($admin_id == $check_id)
                {
                return redirect('/webpanel/admin');

                } else {
                    
                return view('/webpanel/admin-create');
                }
    
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $master = Admin::adminEdit($id);
        $admin_row = $master[0];

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        return view('webpanel/admin-detail', compact('admin_row', 'province', 'amphur', 'district'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
