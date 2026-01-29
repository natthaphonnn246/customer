<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        // เพิ่ม field
        Schema::table('line_users_tb', function (Blueprint $table) {
            $table->string('line_user_id')->after('id');
            $table->string('display_name')->nullable();
            $table->string('picture_url')->nullable();
            $table->text('liff_token')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable(); // รองรับ IPv6
            $table->boolean('status_line')->default(true);
        });
    }

    public function down(): void
    {
        // ลบ field ที่เพิ่ม
        Schema::table('line_users_tb', function (Blueprint $table) {
            $table->dropColumn([
                'line_user_id',
                'display_name',
                'picture_url',
                'liff_token',
                'user_agent',
                'ip_address',
                'status_line',
            ]);
        });

    }
};
