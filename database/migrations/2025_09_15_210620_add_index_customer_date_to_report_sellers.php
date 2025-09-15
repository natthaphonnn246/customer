<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('report_sellers', function (Blueprint $table) {
            DB::statement('ALTER TABLE report_sellers ADD INDEX idx_customer_date (customer_id ASC, date_purchase DESC)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_sellers', function (Blueprint $table) {
            $table->dropIndex('idx_customer_date');
        });
    }
};
