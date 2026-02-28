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
        Schema::table('ordering_item_cancels', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')
                ->nullable()
                ->after('id'); // ปรับตำแหน่งได้ตามต้องการ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordering_item_cancels', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }
};
// return new class extends Migration {
//     protected $connection = 'mysql2'; //ตัวกำหนด DB

//     public function up(): void
//     {
//         Schema::table('vmdrug_customer', function (Blueprint $table) {
//             $table->string('test')->nullable();
//         });
//     }
// };