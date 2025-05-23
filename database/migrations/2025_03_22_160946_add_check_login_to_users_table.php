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
        Schema::table('users', function (Blueprint $table) {
            $table->string('check_login');
            $table->string('date_login');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //add test test;
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['check_login', 'date_login']);
        });
    }
};
