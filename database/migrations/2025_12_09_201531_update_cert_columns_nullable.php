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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('cert_store')->nullable()->change();
            $table->string('cert_medical')->nullable()->change();
            $table->string('cert_commerce')->nullable()->change();
            $table->string('cert_vat')->nullable()->change();
            $table->string('cert_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('cert_store')->nullable(false)->change();
            $table->string('cert_medical')->nullable(false)->change();
            $table->string('cert_commerce')->nullable(false)->change();
            $table->string('cert_vat')->nullable(false)->change();
            $table->string('cert_id')->nullable(false)->change();
        });
    }
};
