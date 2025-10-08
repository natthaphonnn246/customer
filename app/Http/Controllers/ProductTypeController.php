<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Salearea;
use App\Models\Customer;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class ProductTypeController extends Controller
{
        //check password เข้าระบบแบบอนุญาต;
        public function checkLiceseType(Request $request)
        {

            date_default_timezone_set('Asia/Bangkok');

            $password = $request->input('password');

            $user_id = Auth::user()->user_id;
            $user = User::where('user_id', $user_id)->first();
        
            if ($user && Hash::check($password, $user->password)) {
                $check_login = 1;
            } else {
                $check_login = 0;
            }
 
            $lastActivity = $check_login == 1 ? now() : null;

            ProductType::create([
                                    'user_id' => $user?->user_id,
                                    'user_name' => $user?->name,
                                    'email' => $user?->email,
                                    'login_count' => 1,
                                    'checked' => $check_login,
                                    'login_date' => now(),
                                    'last_activity' => $lastActivity,
                                    'ip_address' => $request->ip(),
                                ]);
            
        
                            return response()->json(['valid' => $check_login]);
        }

        //portal;
        public function limitedSale(Request $request)
        {

                $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

                $id = $request->user()->admin_area;
                $code = $request->user()->user_code;
        
                $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
                $status_all = DB::table('customers')->select('status')
                                        ->where('admin_area', $id)
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
        
                $status_waiting = DB::table('customers')->where('admin_area', $id)
                                            ->where('status', 'รอดำเนินการ')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();
                                            // dd($count_waiting);
                $status_action = DB::table('customers')->where('admin_area', $id)
                                            ->where('status', 'ต้องดำเนินการ')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();
        
                $status_completed = DB::table('customers')->where('admin_area', $id)
                                            ->where('status', 'ดำเนินการแล้ว')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();
        
                $status_alert = $status_waiting + $status_action;

                $product_dextro = Product::where('generic_name','LIKE', '%dextro%')
                                    ->select(
                                            'product_id',
                                            'product_name',
                                            'generic_name',
                                            'unit'
                                            )
                                    // ->where('status', 'เปิด')
                                    ->orderBy('product_id', 'ASC')
                                    ->get();

                $keywords = ['sildenafil', 'Tadalafil'];
                $product_viagra = Product::where(function($q) use ($keywords) {
                                        foreach ($keywords as $keyword) {
                                            $q->orWhere('generic_name', 'LIKE', "%{$keyword}%");
                                        }
                                    })
                                    ->select(
                                            'product_id',
                                            'product_name',
                                            'generic_name',
                                            'unit'
                                            )
                                    // ->where('status', 'เปิด')
                                    ->orderBy('product_id', 'ASC')
                                    ->get();
    
                return view('portal/product-limited-sales', compact(
                                                        'user_name', 
                                                        'status_all', 
                                                        'status_waiting', 
                                                        'status_action', 
                                                        'status_completed', 
                                                        'status_alert',
                                                        'product_dextro',
                                                        'product_viagra'
                                                    ));
        }

         //webpanel;
         public function limitedSaleWebpanel(Request $request)
         {
 
                $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

                $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();
        
                $status_updated = Customer::where('status_update', 'updated')
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();
        
                $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();
        
                $status_alert = $status_waiting + $status_updated;
        
                $user_id_admin = $request->user()->user_id;
        
                //dropdown admin_area;
                $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
        
                //dropdown sale_area;
                $sale_area =  Salearea::select('sale_area', 'sale_name')->get();

                $product_dextro = Product::where('generic_name','LIKE', '%dextro%')
                                    ->select(
                                            'product_id',
                                            'product_name',
                                            'generic_name',
                                            'unit'
                                            )
                                    // ->where('status', 'เปิด')
                                    ->orderBy('product_id', 'ASC')
                                    ->get();

                $keywords = ['sildenafil', 'Tadalafil'];
                $product_viagra = Product::where(function($q) use ($keywords) {
                                        foreach ($keywords as $keyword) {
                                            $q->orWhere('generic_name', 'LIKE', "%{$keyword}%");
                                        }
                                    })
                                    ->select(
                                            'product_id',
                                            'product_name',
                                            'generic_name',
                                            'unit'
                                            )
                                    // ->where('status', 'เปิด')
                                    ->orderBy('product_id', 'ASC')
                                    ->get();
    
                return view('product/limited-sales', compact(
                                                    'status_alert',
                                                    'status_registration', 
                                                    'status_waiting', 
                                                    'status_updated',
                                                    'user_id_admin',
                                                    'product_dextro',
                                                    'product_viagra'
                                                    ));
        }
}
