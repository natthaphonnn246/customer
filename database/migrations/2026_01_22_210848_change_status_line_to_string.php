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
        Schema::table('line_users_tb', function (Blueprint $table) {
            $table->string('status_line', 50)
                  ->default('active')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('line_users_tb', function (Blueprint $table) {
            $table->boolean('status_line')
                  ->default(true)
                  ->change();
        });
    }
};
