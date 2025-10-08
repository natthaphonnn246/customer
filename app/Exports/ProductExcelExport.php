<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Customer;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ReportSeller;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class ProductExcelExport
{
    use Exportable;
    public function exportSellerExcel(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");

        $from = $request->from;
        $to = $request->to;
        $category = $request->category;
        $region = $request->region;
        // dd($min_selling);

        if(!empty($from) && !empty($to))
        {
        //    dd('test');
            if (!empty($region) && empty($category)) {

                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = ''.$region.'_'. $date;
                            // Start the output buffer.

                        return ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                            )
                                            ->join('products', function (JoinClause $join) {
                                                $join->on('products.product_id', '=', 'report_sellers.product_id');
                                            })
                                            ->join('categories', function (JoinClause $join) {
                                                $join->on('categories.categories_id', '=', 'products.category');
                                            })
                                            ->join('subcategories', function (JoinClause $join) {
                                                $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                            })
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                            ->where('customers.geography', $region)
                                            ->whereBetween('report_sellers.date_purchase', [$from, $from])
                                            ->groupBy(
                                                'report_sellers.product_id',
                                                'products.category',
                                                'products.product_name',
                                                'products.sub_category',
                                                'categories.categories_name',
                                                'subcategories.subcategories_name',
                                                'products.unit',
                                                'customers.geography',
                                            )
                                            ->orderBy('quantity_by', 'desc')
                                            ->downloadExcel('Product_value'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);

                } elseif (!empty($category) && empty($region)) {

                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_'.$category.'_'. $date;

                        return ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                            )
                                            ->join('products', function (JoinClause $join) {
                                                $join->on('products.product_id', '=', 'report_sellers.product_id');
                                            })
                                            ->join('categories', function (JoinClause $join) {
                                                $join->on('categories.categories_id', '=', 'products.category');
                                            })
                                            ->join('subcategories', function (JoinClause $join) {
                                                $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                            })
                                            ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                            ->where('products.category', $category)
                                            ->whereBetween('report_sellers.date_purchase', [$from, $to])
                                            ->groupBy(
                                                'report_sellers.product_id',
                                                'products.category',
                                                'products.product_name',
                                                'products.sub_category',
                                                'categories.categories_name',
                                                'subcategories.subcategories_name',
                                                'products.unit'
                                            )
                                            ->orderBy('quantity_by', 'desc')
                                            ->downloadExcel('Product_value'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);

                    } elseif(!empty($region) && !empty($category)) {

                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_'.$region.'_'.$category.'_'.$date;

                        return ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                            )
                                            ->join('products', function (JoinClause $join) {
                                                $join->on('products.product_id', '=', 'report_sellers.product_id');
                                            })
                                            ->join('categories', function (JoinClause $join) {
                                                $join->on('categories.categories_id', '=', 'products.category');
                                            })
                                            ->join('subcategories', function (JoinClause $join) {
                                                $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                            })
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                            ->where('products.category', $category)
                                            ->where('customers.geography', $region)
                                            ->whereBetween('report_sellers.date_purchase', [$from, $to])
                                            ->groupBy(
                                                'report_sellers.product_id',
                                                'products.category',
                                                'products.product_name',
                                                'products.sub_category',
                                                'categories.categories_name',
                                                'subcategories.subcategories_name',
                                                'products.unit',
                                                'customers.geography',
                                            )
                                            ->orderBy('quantity_by', 'desc')
                                            ->downloadExcel('Product_value'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                                            
                    } else {

                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_'. $date;
                            // Start the output buffer.

                        return ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                            )
                                            ->join('products', function (JoinClause $join) {
                                                $join->on('products.product_id', '=', 'report_sellers.product_id');
                                            })
                                            ->join('categories', function (JoinClause $join) {
                                                $join->on('categories.categories_id', '=', 'products.category');
                                            })
                                            ->join('subcategories', function (JoinClause $join) {
                                                $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                            })
                                            ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                            ->whereBetween('report_sellers.date_purchase', [$from, $to])
                                            ->groupBy(
                                                'report_sellers.product_id',
                                                'products.category',
                                                'products.product_name',
                                                'products.sub_category', 
                                                'categories.categories_name',
                                                'subcategories.subcategories_name',
                                                'products.unit'
                                            )
                                            ->orderBy('quantity_by', 'desc')
                                            ->downloadExcel('Product_value'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                        }

            } else {

                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_all_'. $date;

                        return ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                            )
                                            ->join('products', function (JoinClause $join) {
                                                $join->on('products.product_id', '=', 'report_sellers.product_id');
                                            })
                                            ->join('categories', function (JoinClause $join) {
                                                $join->on('categories.categories_id', '=', 'products.category');
                                            })
                                            ->join('subcategories', function (JoinClause $join) {
                                                $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                            })
                                            ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                            ->groupBy(
                                            'report_sellers.product_id',
                                            'products.category',
                                            'products.product_name',
                                            'products.sub_category', 
                                            'categories.categories_name',
                                            'subcategories.subcategories_name',
                                            'products.unit'
                                            )
                                            ->orderBy('quantity_by', 'desc')
                                            ->downloadExcel('Product_value'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);

            }
            
    }

    public function exportItemExcel(Request $request)
    {
        
        // dd('test');
        date_default_timezone_set("Asia/Bangkok");

        $from = $request->from;
        $to = $request->to;
        $category = $request->category;
        $region = $request->region;
        $product_id = $request->id;
        // dd($product_id);

        if(!empty($from) && !empty($to))
        {
            if(!empty($category) && !empty($region)) {
                
                $date = $from.'_'.'to'.'_'.$to;
                $filename = '_'.$product_id.'_'.$category.'_'. $date;

                return ReportSeller::select(
                                    'report_sellers.customer_id',
                                    'customers.customer_name',
                                    'products.unit',
                                    DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                    )
                                    ->join('products', function (JoinClause $join) {
                                        $join->on('products.product_id', '=', 'report_sellers.product_id');
                                    })
                                    ->join('customers', function (JoinClause $join) {
                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                    })
                                    ->join('categories', function (JoinClause $join) {
                                        $join->on('categories.categories_id', '=', 'products.category');
                                    })
                        
                                    ->groupBy(
                                    'report_sellers.customer_id',
                                    'customers.customer_name',
                                    'products.unit'
                        /*             'products.category',
                                    'customers.geography', */
                                    )
                                    ->where('report_sellers.product_id', $product_id)
                                    ->where('products.category', $category)
                                    ->where('customers.geography', $region) 
                                    ->whereBetween('report_sellers.date_purchase', [$from, $to])
                                    ->orderBy('quantity_by', 'desc')
                                    ->downloadExcel('Product_item'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);

            
            } else {

                // dd('excel');
                $date = $from.'_'.'to'.'_'.$to;
                $filename = '_'.$product_id.'_'.$date.'_';
    
                return ReportSeller::select(
                                    'report_sellers.customer_id',
                                    'report_sellers.customer_name',
                                    'products.unit',
                                    DB::raw('SUM(report_sellers.quantity) as quantity_by'),
/*                                         DB::raw('AVG(report_sellers.cost) as average_cost'),
                                    DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'), */
                                    )
                                    ->join('products', function (JoinClause $join) {
                                        $join->on('products.product_id', '=', 'report_sellers.product_id');
                                    })
                                    /*   ->join('customers', function (JoinClause $join) {
                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                    }) */
                                /*   */
                                    ->groupBy(
                                    'report_sellers.customer_id',
                                    'report_sellers.customer_name',
                                    'products.unit'
                                    )
                                    ->where('report_sellers.product_id', $product_id)
                                    ->whereBetween('report_sellers.date_purchase', [$from, $to])
                                    ->orderBy('quantity_by', 'desc')
                                    ->downloadExcel('Product_item'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);


            }

        } else {

            $date = $from.'_'.'to'.'_'.$to;
            $filename = '_'.$product_id.'_'.$date.'_';

            return ReportSeller::select(
                                'report_sellers.customer_id',
                                    'customers.customer_name',
                                    'products.unit',
                                    DB::raw('SUM(report_sellers.quantity) as quantity_by'),
/*                                         DB::raw('AVG(report_sellers.cost) as average_cost'),
                                    DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'), */
                                    )
                                    ->join('products', function (JoinClause $join) {
                                        $join->on('products.product_id', '=', 'report_sellers.product_id');
                                    })
                                    ->join('customers', function (JoinClause $join) {
                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                    })
                                /*   */
                                    ->groupBy(
                                    'report_sellers.customer_id',
                                    'customers.customer_name',
                                    'products.unit'
                                    )
                                    ->where('report_sellers.product_id', $product_id)
                                    ->orderBy('quantity_by', 'desc')
                                    ->cursor();

                    $data = $report_product->toArray();
                    // dd('dd');
                    ob_end_clean();

        }

    }

    public function deadStockExcel(Request $request)
    {

            // dd('test');
            date_default_timezone_set("Asia/Bangkok");

            $from = $request->from;
            $to   = $request->to;
            $date = $from.'_to_'.$to;
        
            // ดึงข้อมูลจาก DB
            $data = DB::table('products as p')
                    ->leftJoin('report_sellers as r', function ($join) use ($from, $to) {
                        $join->on('p.product_id', '=', 'r.product_id')
                            ->whereBetween('r.date_purchase', [$from, $to]);
                    })
                    ->select(
                        'p.product_id',
                        'p.product_name',
                        'p.generic_name',
                        'p.quantity',
                        'p.unit',
                        'p.status'
                    )
                    ->where('p.status', 'เปิด')
                    ->whereNull('r.product_id')
                    ->orderBy('p.product_id')
                    ->get();
        
            // สร้าง Export class แบบ inline
            $export = new class($data) implements FromCollection, WithHeadings {
                    protected $data;
            
                    public function __construct($data)
                    {
                        $this->data = $data;
                    }
            
                    public function collection()
                    {
                        return $this->data;
                    }
            
                    public function headings(): array
                    {
                        return [
                            'Product ID',
                            'Product Name',
                            'Generic Name',
                            'Quantity',
                            'Unit',
                            'Status',
                        ];
                    }
                };
        
            // ดาวน์โหลดไฟล์ Excel
            return Excel::download($export, 'สินค้าไม่เคลื่อนไหว_'.$date.'.xlsx');

    }
}
