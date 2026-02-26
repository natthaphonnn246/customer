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
        Schema::create('special_deals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained();
            $table->string('product_code')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('qty_pack');
            $table->string('unit')->default('pack');
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(false);

            $table->foreignId('created_by_id')->constrained('users');

            $table->string('ip', 45)->nullable();
            $table->integer('stock_pack');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_deals');
    }
};
