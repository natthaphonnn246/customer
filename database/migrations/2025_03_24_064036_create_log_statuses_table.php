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
        //test
        Schema::create('tb_log_status', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('email');
            $table->string('user_name');
            $table->integer('login_count');
            $table->string('login_date');
            $table->string('log_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_log_status');
    }
};
