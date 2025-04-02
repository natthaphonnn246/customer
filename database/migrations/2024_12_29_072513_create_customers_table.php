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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('customer_code');
            $table->string('customer_name');
            $table->string('price_level');
            $table->string('email');
            $table->string('phone');
            $table->string('telephone');
            $table->string('address');
            $table->string('province');
            $table->string('amphur');
            $table->string('district');
            $table->string('zip_code');
            $table->string('admin_area');
            $table->string('sale_area');
            $table->string('text_area');
            $table->binary('cert_store');
            $table->binary('cert_medical');
            $table->binary('cert_commerce');
            $table->binary('cert_vat');
            $table->binary('cert_id');
            $table->string('cert_number');
            $table->dateTime('cert_expire');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
