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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('business_type')->nullable();
            $table->json('product_categories')->nullable();
            $table->text('products_offered')->nullable();
            $table->text('products_interested')->nullable();
            $table->string('buying_frequency')->nullable();
            $table->string('website')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('verification_doc')->nullable();
            $table->boolean('verified_by_admin')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};