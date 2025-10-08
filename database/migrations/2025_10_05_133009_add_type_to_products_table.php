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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('khor_yor_1')->default(0);
            $table->boolean('khor_yor_2')->default(0);
            $table->boolean('som_phor_2')->default(0);
            $table->boolean('clinic')->default(0); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('khor_yor_1');
            $table->dropColumn('khor_yor_2');
            $table->dropColumn('som_phor_2');
            $table->dropColumn('clinic');
        });
    }
};
