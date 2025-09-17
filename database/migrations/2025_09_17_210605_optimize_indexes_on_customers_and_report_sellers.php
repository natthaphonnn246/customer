<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ลบ index ซ้ำบน customers.admin_area
        try {
            DB::statement('ALTER TABLE customers DROP INDEX idx_customers_admin_area');
        } catch (\Exception $e) {
            // ignore ถ้า index ไม่มี
        }

        try {
            DB::statement('ALTER TABLE customers DROP INDEX idx_customers_admin');
        } catch (\Exception $e) {
            // ignore ถ้า index ไม่มี
        }

        // สร้าง composite index admin_area + customer_id
        DB::statement('CREATE INDEX idx_customers_admin_customer ON customers(admin_area, customer_id)');

        // สร้าง index บน report_sellers สำหรับ MAX(date_purchase) + join
        DB::statement('CREATE INDEX idx_report_customer_date ON report_sellers(customer_id, date_purchase DESC)');

        // Optional: index สำหรับ status filter
        DB::statement('CREATE INDEX idx_customers_admin_status ON customers(admin_area, status)');
    }

    public function down(): void
    {
        // Rollback
        try {
            DB::statement('ALTER TABLE customers DROP INDEX idx_customers_admin_customer');
        } catch (\Exception $e) {}

        try {
            DB::statement('ALTER TABLE report_sellers DROP INDEX idx_report_customer_date');
        } catch (\Exception $e) {}

        try {
            DB::statement('ALTER TABLE customers DROP INDEX idx_customers_admin_status');
        } catch (\Exception $e) {}
    }
};
