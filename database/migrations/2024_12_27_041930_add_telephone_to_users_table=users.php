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
        Schema::table('users', function (Blueprint $table) {
           
            $table->string('user_id');
            $table->string('telephone');
            $table->string('address');
            $table->string('province');
            $table->string('amphur');
            $table->string('district');
            $table->string('zipcode');
            $table->string('email_login');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
