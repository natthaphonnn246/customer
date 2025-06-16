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
            $table->index('purchase_order');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('sale_area');
            $table->index('admin_area');
            $table->index('delivery_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_sellers', function (Blueprint $table) {
            $table->dropIndex(['purchase_order']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['sale_area']);
            $table->dropIndex(['admin_area']);
            $table->dropIndex(['delivery_by']);
        });
    }
};
