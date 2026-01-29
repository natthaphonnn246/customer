<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use Illuminate\Support\Str;

class GenerateCustomerSlug extends Command
{
    /**
     * ชื่อคำสั่ง
     */
    protected $signature = 'customer:generate-slug';

    /**
     * คำอธิบาย
     */
    protected $description = 'Generate slug for customers who do not have slug';

    public function handle()
    {
        Customer::whereNull('slug')
            ->orWhere('slug', '')
            ->chunk(100, function ($customers) {

                foreach ($customers as $customer) {

                    // 1. สร้าง slug จากชื่อ
                    $baseSlug = Str::slug($customer->customer_name);

                    if (empty($baseSlug)) {
                        $baseSlug = 'customer-' . Str::uuid();
                    }

             /*        // 2. fallback กรณีภาษาไทย
                    if ($baseSlug === '') {
                        $baseSlug = 'customer-' . $customer->id;
                    } */

                    $slug = $baseSlug;
                    $count = 1;

                    // 3. กัน slug ซ้ำ
                    while (
                        Customer::where('slug', $slug)
                            ->where('id', '!=', $customer->id)
                            ->exists()
                    ) {
                        $slug = $baseSlug . '-' . $count++;
                    }

                    // 4. update
                    $customer->update([
                        'slug' => $slug
                    ]);
                }
            });

        $this->info('Generate customer slug completed');
    }

    // php artisan customer:generate-slug

 /*    SELECT * 
    FROM customers
    WHERE slug IS NULL
    OR slug = ''; */
}