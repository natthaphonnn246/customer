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
        Schema::create('report_sellers', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order');
            $table->string('report_sellers_id');
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('product_id');
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->string('unit');
            $table->date('date_purchase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_sellers');
    }
};