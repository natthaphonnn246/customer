<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotion_orders', function (Blueprint $table) {
            
            $table->string('created_by')->nullable()->change();

            $table->foreignId('created_by_id')
                  ->nullable()
                  ->after('created_by')
                  ->constrained('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('promotion_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by_id');
        });
    }
};
