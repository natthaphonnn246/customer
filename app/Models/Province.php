<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    public static function province()
    {
        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        return $province;
    }

    public static function ampure($province_id)
    {
        $ampure = DB::table('amphures')->select('name_th', 'province_id')->where('province_id', $province_id)->get();
        return $ampure;
    }

    public static function district($amphure_id)
    {
        $district = DB::table('districts')->select('name_th', 'amphure_id', 'id', 'zip_code')->where('amphure_id', $amphure_id)->get();
        return $district;
    }
    public static function zipcode($check_id)
    {
        $district = DB::table('districts')->select('zip_code', 'amphure_id', 'id', 'name_th')->where('id', $check_id)->get();
        return $district;
    }
    public static function geography($check_id)
    {
        $geography = DB::table('geographies')->select('id','name')->where('id', $check_id)->first();
        return $geography;
    }
    
}
