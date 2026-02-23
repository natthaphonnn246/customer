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
        Schema::create('promotion_orders', function (Blueprint $table) {
            $table->id();
        
            $table->string('po')->unique(); 
            $table->unsignedBigInteger('created_by'); 
        
            $table->date('order_date')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0); 
        
            $table->string('status')->default('draft'); 
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_orders');
    }
};
