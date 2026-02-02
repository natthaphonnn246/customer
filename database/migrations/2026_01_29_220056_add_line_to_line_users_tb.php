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
        if (Schema::hasTable('line_users_tb') && Schema::hasColumn('line_users_tb', 'line_user_id')) {
            Schema::table('line_users_tb', function (Blueprint $table) {
                try {
                     $table->string('line_user_id')->nullable()->change();
                } catch (\Exception $e) {
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('line_users_tb') && Schema::hasColumn('line_users_tb', 'line_user_id')) {
            Schema::table('line_users_tb', function (Blueprint $table) {
                try {
                    $table->string('line_user_id')->nullable(false)->change();
                } catch (\Exception $e) {
                }
            });
        }
    }
};
