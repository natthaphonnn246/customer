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
        Schema::create('purchases_tb', function (Blueprint $table) {
            $table->id();
        
            $table->string('po_number')->unique();
            $table->date('po_date')->index();
        
            $table->string('customer_code', 50)->index();
            $table->string('customer_name');
            $table->string('price_level', 50)->nullable();
        
            $table->enum('status', ['draft', 'confirmed'])->default('draft');
            $table->decimal('total_amount', 12, 2)->default(0);
        
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases_tb');
    }
};
