<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinceController 
{
    public function index()
    {     
            $provinces = Province::province();

            $status_waiting = Customer::where('status', '0')
                                        ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->count();

            $status_updated = Customer::where('status_update', 'updated')
                                        ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->count();

                    $status_alert = $status_waiting + $status_updated;

            return view('/webpanel/admin-create', compact('provinces', 'status_alert', 'status_waiting', 'status_updated'));
    }
 /*    public function customerCreate()
    {
            $provinces = Province::province();
            return view('/webpanel/customer-create', compact('provinces'));
    } */

   /*  public function indexPortal()
    {
            $provinces = Province::province();
            return view('/portal/signin', compact('provinces'));
    } */
    /* public function portalSign(Request $request)
    {
            $code = $request->user()->user_code;
        
            $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->get();

            $provinces = Province::province();
            return view('portal/portal-sign', compact('provinces', 'user_name'));
    } */
    
    public function amphure()
    {
            @$province_id = $_GET['province_id'];
    
            if($province_id != '')
            {
                $ampure_master = Province::ampure($province_id);
                foreach ($ampure_master as $row)
                {

                echo "<option value='". $row->name_th. "'>". $row->name_th. "</option>";
                }

            }

    }

    public function district()
    {

            @$amphure_id = $_GET['amphure_id'];

            $check_row = DB::table('amphures')->select('id', 'name_th')->whereIn('name_th', [$amphure_id])->get();
            foreach ($check_row as $row)
            {
                $check_id = $row->id;
            }

            if($check_id != '')
            {
                $district_master = Province::district($check_id);
                foreach ($district_master as $row)
                {
                echo "<option value='". $row->name_th. "'>". $row->name_th. "</option>";
                }
            }
            

    }

    public function zipcode()
    {

            @$amphure_name = $_GET['amphure_id'];

            $zipcode_row = DB::table('districts')->select('zip_code', 'amphure_id', 'id')->whereIn('name_th', [$amphure_name])->get();
            foreach ($zipcode_row as $row)
            {
                // $check_id = $row->id;
                $check_id = $row->id;
                $check_amphure = $row->amphure_id;
            }

            if($check_id != '')
            {
                $zip_master = Province::zipcode($check_id);
                foreach ($zip_master as $row)
                {
                 
                    $zipcode = $row->zip_code;
                    echo $zipcode;
                   
                }
            }


    }

    public function geographies()
    {

            @$province_id = $_GET['province_id'];
            $georaphy_row = DB::table('provinces')->select('geography_id', 'id')->where('id', $province_id)->first();
            $geography_id = $georaphy_row->geography_id;

            if($geography_id  != '')
            {
                $geography_master = Province::geography($geography_id);
                $geography_name = $geography_master->name;
                echo $geography_name;
                
            }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        //
    }
}
