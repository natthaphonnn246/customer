<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->index('admin_area', 'idx_customers_admin');
        });

        Schema::table('report_sellers', function (Blueprint $table) {
            // index สำหรับ join และ order
            $table->index(['customer_id', 'date_purchase'], 'idx_report_sellers_date_pur');
            $table->index('customer_id', 'idx_report_sellers_customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('idx_customers_admin');
        });

        Schema::table('report_sellers', function (Blueprint $table) {
            $table->dropIndex('idx_report_sellers_date_pur');
            $table->dropIndex('idx_report_sellers_customer_id');
        });
    }
};
