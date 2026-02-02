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
        if (Schema::hasTable('line_users_tb') && Schema::hasColumn('line_users_tb', 'status_line')) {
            Schema::table('line_users_tb', function (Blueprint $table) {
                try {
                     $table->string('status_line', 50)->default('active')->change();
                } catch (\Exception $e) {
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('line_users_tb') && Schema::hasColumn('line_users_tb', 'status_line')) {
            Schema::table('line_users_tb', function (Blueprint $table) {
                try {
                    $table->boolean('status_line')->default(true)->change();
                } catch (\Exception $e) {
                }
            });
        }
    }
};
