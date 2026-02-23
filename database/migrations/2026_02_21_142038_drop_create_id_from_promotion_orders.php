<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotion_orders', function (Blueprint $table) {
            $table->dropColumn('created_id');
        });
    }

    public function down(): void
    {
        Schema::table('promotion_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('created_id')->nullable();
        });
    }
};