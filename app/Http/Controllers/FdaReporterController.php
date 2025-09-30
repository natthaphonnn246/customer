<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportSeller;
use App\Imports\SellersImport;
use App\Models\Salearea;
use App\Models\ImportStatus;
use App\Models\Customer;
use App\Models\user;
use Illuminate\View\View;
use Illuminate\Http\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Jobs\RebuildCheckPurchaseCache;

class FdaReporterController extends Controller
{
    public function FdaReporter(Request $request) 
    {

        $from = $request->from ?? date('Y-m-d');
        $to   = $request->to ?? date('Y-m-d');
        $generic = $request->generic ?: 'ไม่ระบุ'; 
        $product = $request->product ?: 'ไม่ระบุ'; 
        
        //notin code;
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

        $reporter = DB::table('report_sellers as r')
                        ->join('customers as c', 'c.customer_id', '=', 'r.customer_id')
                        ->join('products as p', 'p.product_id', '=', 'r.product_id')
                        ->select(
                            'r.customer_id',
                            'c.customer_name',
                            'r.product_id',
                            'p.product_name',
                            'p.generic_name',
                            DB::raw('SUM(r.quantity) as qty'),
                            'p.unit',
                            'r.date_purchase'
                        )
                        ->whereBetween('r.date_purchase', [$from, $to])
                        ->where('p.generic_name', 'LIKE', "%{$generic}%")
                        ->orWhere('p.product_name', 'Like', "%{$product}%")
                        ->orWhere('p.product_id', 'Like', "%{$product}%")
                        ->groupBy(
                            'r.customer_id',
                            'c.customer_name',
                            'r.product_id',
                            'p.product_name',
                            'p.generic_name',
                            'p.unit',
                            'r.date_purchase'
                        )
                        ->orderBy('c.customer_id', 'asc')
                        ->get();
    
                          
                        // dd($reporter);
        return view('webpanel/fdareporter', compact(
                                                    'status_alert',
                                                    'status_registration', 
                                                    'status_waiting', 
                                                    'status_updated',
                                                    'user_id_admin',
                                                    'reporter'
                                                ));

    }
}
