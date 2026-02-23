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
        Schema::create('promotion_items', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('promotion_order_id'); // FK
            $table->string('product_id');
            $table->string('product_name');
        
            $table->integer('qty'); 
            $table->string('unit')->nullable();
        
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
        
            $table->text('note')->nullable();
            $table->date('expire')->nullable();
        
            $table->timestamps();
        
            $table->foreign('promotion_order_id')
                  ->references('id')
                  ->on('promotion_orders')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_items');
    }
};
