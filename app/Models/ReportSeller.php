<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportSeller extends Model
{
    protected $fillable = [

        'purchase_order',
        'report_sellers_id',
        'customer_id',
        'customer_name',
        'product_id',
        'product_name',
        'price',
        'cost',
        'quantity',
        'unit',
        'date_purchase',

    ];

    protected $table = 'report_sellers';
    protected $connection = 'mysql';

/*     public static function reportSeller($page)
    {


        $pagination = ReportSeller::select(DB::raw('DISTINCT(customer_id)'))
                                    ->whereBetween('date_purchase', ['2025-02-24', '2025-02-25'])
                                    ->get();
        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $report_seller = ReportSeller::select('customer_id', DB::raw('SUM(price*quantity) as total_sales'))
                                        ->groupBy('customer_id')
                                        // ->having('date_purchase')
                                        ->whereBetween('date_purchase', ['2025-02-24', '2025-02-25'])
                                        ->offset($start)
                                        ->limit($perpage)
                                        ->get();

        return [$report_seller, $start, $total_page, $page];
    } */
}
