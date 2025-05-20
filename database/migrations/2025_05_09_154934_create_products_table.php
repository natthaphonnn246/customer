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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('product_name');
            $table->string('generic_name');
            $table->string('category');
            $table->string('sub_category');
            $table->string('type');
            $table->string('unit');
            $table->decimal('price_1', 10, 2)->default(0.00);
            $table->decimal('price_2', 10, 2)->default(0.00);
            $table->decimal('price_3', 10, 2)->default(0.00);
            $table->decimal('price_4', 10, 2)->default(0.00);
            $table->decimal('price_5', 10, 2)->default(0.00);
            $table->integer('quantity');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
