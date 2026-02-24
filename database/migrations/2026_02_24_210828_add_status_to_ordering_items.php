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
        Schema::table('ordering_items', function (Blueprint $table) {
            $table->unsignedBigInteger('cancel_by')->nullable();
            $table->string('cancel_by_name')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('status')->default('draft');

            $table->index('status');
            $table->index('cancel_by');

            $table->index(['order_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordering_items', function (Blueprint $table) {

            $table->dropIndex(['order_id', 'status']);
            $table->dropIndex(['status']);
            $table->dropIndex(['cancel_by']);

            $table->dropColumn([
                'cancel_by',
                'cancel_by_name',
                'cancelled_at',
                'status'
            ]);
        });
    }
};
