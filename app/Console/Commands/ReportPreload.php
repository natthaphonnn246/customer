<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\ReportSeller;

class ReportPreload extends Command
{
    protected $signature = 'report:preload';
    protected $description = 'Preload report data and store it in cache';
    // protected $description = 'Preload report data and store in cache';

    public function handle()
    {
        $filters_s = [
            'from' => '2025-01-01',
            'to'   => '2025-01-15',
        ];

        // $key = 'report_all_data_' . md5(json_encode($filters_s));
        $key = 'report_all_data';

        if (!Cache::has($key)) {
            $data = ReportSeller::select(
                            'report_sellers.product_id',
                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                            'products.category',
                            'products.sub_category',
                            'products.product_name',
                            'categories.categories_name',
                            'subcategories.subcategories_name',
                            'products.unit',
         
                        )
                        ->join('products', 'products.product_id', '=', 'report_sellers.product_id')
                        ->join('categories', 'categories.categories_id', '=', 'products.category')
                        ->join('subcategories', 'subcategories.subcategories_id', '=', 'products.sub_category')
                        ->groupBy(
                            'report_sellers.product_id',
                            'products.category',
                            'products.product_name',
                            'products.sub_category',
                            'categories.categories_name',
                            'subcategories.subcategories_name',
                            'products.unit',

                        )
                        // ->whereBetween('report_sellers.date_purchase', [$filters_s['from'], $filters_s['to']])
                        ->orderBy('quantity_by', 'desc')
                        ->get();

            Cache::put($key, $data, now()->addMinutes(2));
            $this->info('Report data has been preloaded and cached.');
        } else {
            $this->info('Data already exists in cache.');
        }
    }
}


