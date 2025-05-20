<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        Schema::table('products', function (Blueprint $table) {
            $table->index('product_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('categories_id');
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->index('subcategories_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('customer_id');
        });
    }

    public function down(): void
    {

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['categories_id']);
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropIndex(['subcategories_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['customer_id']);
        });
    }
};

