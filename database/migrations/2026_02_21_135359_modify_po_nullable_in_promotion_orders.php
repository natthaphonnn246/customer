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
        Schema::table('promotion_orders', function (Blueprint $table) {
            $table->string('po')->nullable()->change();
        });
    }
    
    public function down(): void
    {
        Schema::table('promotion_orders', function (Blueprint $table) {
            $table->string('po')->nullable(false)->change();
        });
    }
};
