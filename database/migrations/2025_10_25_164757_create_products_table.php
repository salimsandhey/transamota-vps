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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('cascade');
            $table->string('name', 150);
            $table->string('slug', 180);
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('moq'); // Minimum order quantity
            $table->string('unit', 50); // Unit type
            $table->string('origin_country', 100); // Country of product
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};