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
        Schema::table('report_sellers', function (Blueprint $table) {
            // สร้าง composite index customer_id + date_purchase
            $table->index(['customer_id', 'date_purchase'], 'idx_report_sellers_customer_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_sellers', function (Blueprint $table) {
            $table->dropIndex('idx_report_sellers_customer_date');
        });
    }
};
