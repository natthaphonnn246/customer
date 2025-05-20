<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('report_sellers', function (Blueprint $table) {
            $table->index('product_id');
            $table->index('customer_id');
            $table->index('date_purchase');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('category');
            $table->index('sub_category');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('geography');
        });
    }

    public function down(): void
    {
        Schema::table('report_sellers', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['date_purchase']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['sub_category']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['geography']);
        });
    }
};
