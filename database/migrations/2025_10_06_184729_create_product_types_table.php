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
        Schema::create('tb_log_type', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('email')->unique();
            $table->integer('login_count')->default(0);
            $table->boolean('checked')->default(false);
            $table->timestamp('login_date')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('tb_log_type');
    }
    
};
