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
            $table->enum('role', ['buyer', 'seller', 'admin'])->default('buyer');
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('profile_image')->nullable();
            $table->boolean('verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'company_name', 'phone', 'city', 'country', 'profile_image', 'verified']);
        });
    }
};