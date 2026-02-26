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
        Schema::table('ordering_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')
                  ->nullable()
                  ->after('id'); // ปรับตำแหน่งได้ตามต้องการ
        });
    }

    public function down(): void
    {
        Schema::table('ordering_items', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }
};
