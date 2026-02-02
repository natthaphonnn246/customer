<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('line_accounts') && !Schema::hasTable('line_users_tb')) {
            Schema::rename('line_accounts', 'line_users_tb');
        }

        if (!Schema::hasTable('line_users_tb')) {
            Schema::create('line_users_tb', function (Blueprint $table) {
                $table->id();
                $table->string('line_user_id')->nullable();
                $table->string('display_name')->nullable();
                $table->string('picture_url')->nullable();
                $table->text('liff_token')->nullable();
                $table->text('user_agent')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('status_line', 50)->default('active');
                $table->timestamps();
            });
        } else {
            Schema::table('line_users_tb', function (Blueprint $table) {
                if (!Schema::hasColumn('line_users_tb', 'line_user_id')) {
                    $table->string('line_user_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('line_users_tb', 'display_name')) {
                    $table->string('display_name')->nullable();
                }
                if (!Schema::hasColumn('line_users_tb', 'picture_url')) {
                    $table->string('picture_url')->nullable();
                }
                if (!Schema::hasColumn('line_users_tb', 'liff_token')) {
                    $table->text('liff_token')->nullable();
                }
                if (!Schema::hasColumn('line_users_tb', 'user_agent')) {
                    $table->text('user_agent')->nullable();
                }
                if (!Schema::hasColumn('line_users_tb', 'ip_address')) {
                    $table->string('ip_address', 45)->nullable();
                }
                if (!Schema::hasColumn('line_users_tb', 'status_line')) {
                    $table->string('status_line', 50)->default('active');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('line_users_tb');
    }
};
