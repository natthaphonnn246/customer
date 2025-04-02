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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name');
            $table->string('code');
            $table->boolean('role')->nullable();
            $table->string('status_check');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('province');
            $table->string('amphur');
            $table->string('district');
            $table->string('zipcode');
            $table->string('email_login')->unique();
            $table->string('password');
            $table->longText('text_add');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
