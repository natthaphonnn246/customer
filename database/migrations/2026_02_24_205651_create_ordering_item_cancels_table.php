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
        Schema::create('ordering_item_cancels', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ordering_item_id');
            $table->string('product_code');

            $table->decimal('price', 10, 2)->default(0);
            $table->integer('qty')->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->unsignedBigInteger('cancel_by')->nullable();
            $table->string('cancel_by_name')->nullable();

            $table->string('ip', 45)->nullable(); // รองรับ IPv6
            $table->text('cancel_reason')->nullable();

            $table->index('ordering_item_id');
            $table->index('product_code');
            $table->index('cancel_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordering_item_cancels');
    }
};
