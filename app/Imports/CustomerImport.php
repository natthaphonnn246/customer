<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;

class CustomerImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

            if ($row[0] ??= '') 
            {

                $customer_name_new = str_replace("'", "''", $row[2]);
                $address = str_replace("'", "''", $row[4]);
                $cert_number = str_replace("'", "''", $row[5]);
                $cert_expire_new = date('2024-12-31'); 
                $type = str_replace("'", "''", $row[8]);

                $province = explode(" ", $row[4]);
                $province_new = $province[count($province) - 5];
                // dd($province);
                if($province_new == '' || $province_new == 1) {
                    $province = explode(" ", $row[4]);
                    $province_new = $province[count($province) - 2];
                    
                }

                $province_check = DB::table('provinces')->select('name_th', 'geography_id')->where('name_th',$province_new)->first();
                // dd($province_check->geography_id);
                $geography_name = DB::table('geographies')->select('id', 'name')->where('id', $province_check->geography_id)->first();
                $name_geography = ($geography_name->name);
                // dd($name_geography);

                $amphur = explode(" ", $row[4]);
                $amphur_new = $amphur[count($amphur) - 6];
                // dd($amphur_new);
                if($amphur_new == '' || $amphur_new == 1) {
                    $amphur = explode(" ", $row[4]);
                    $amphur_new = $amphur[count($amphur) - 9];
                    // dd($amphur_new);
                }

                $district = explode(" ", $row[4]);
                $district_new = $district[count($district) - 1];

                if($district_new == '' || $district_new == 1) {
                    $district = explode(" ", $row[4]);
                    $district_new = $district[count($district) - 13];
                    // dd($district_new);
                    // dd($amphur_new);
                }

                $zip_code = explode(" ", $row[4]);
                $zip_code_new = $zip_code[count($zip_code) - 1];

                $address = explode(" ", $row[4]);
                $address_new = $zip_code[0];

                $sale_area_new = $row[1];
                if ($sale_area_new == '') {
                    $sale_area_new = 'ไม่ระบุ';
                }

                $customer_id = $row[0];
                $customer_code  = $row[0];
                $customer_name = $customer_name_new;
                $price_level = $row[7];
                $email = '';
                $phone = '';
                $telephone = '';
                $address = $address_new;
                $province = $province_new;
                $amphur = $amphur_new;
                $district = $district_new;
                $zip_code = $zip_code_new;
                $geography = $geography_name;
                $admin_area = '';
                $sale_area = $sale_area_new;
                $text_area = '';
                $text_admin = '';
                $cert_store = '';
                $cert_medical = '';
                $cert_commerce = '';
                $cert_vat = '';
                $cert_id = '';
                $cert_number = $cert_number;
                $cert_expire = $cert_expire_new;
                $status = '0';
                $password = '';
                $status_update = '';
                $type = $type;
                $register_by = 'import_naster';
                $customer_status = 'active';
    
                // dd($user_name);

                return new Customer([
                    
                        'customer_id' => $customer_id,
                        'customer_code' => $customer_code,
                        'customer_name' => $customer_name,
                        'price_level' => $price_level,
                        'email' => $email,
                        'phone' => $phone,
                        'telephone' => $telephone,
                        'address' => $address,
                        'province' =>  $province,
                        'amphur' => $amphur,
                        'district' => $district,
                        'zip_code' => $zip_code,
                        'geography' => $name_geography,
                        'admin_area' => $admin_area,
                        'sale_area' => $sale_area,
                        'text_area' => $text_area,
                        'text_admin' => $text_admin,
                        'cert_store' => $cert_store,
                        'cert_medical' =>  $cert_medical,
                        'cert_commerce' => $cert_commerce,
                        'cert_vat' => $cert_vat,
                        'cert_id' => $cert_id,
                        'cert_number' => $cert_number,
                        'cert_expire' => $cert_expire,
                        'status' => $status,
                        'password' => $password,
                        'status_update' => $status_update,
                        'type' => $type,
                        'register_by' => $register_by,
                        'customer_status' => $customer_status,
                        
                    ]);

            }

    }
        
}




      
   

