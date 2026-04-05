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
        Schema::create('group_chat_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_chat_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            
            $table->foreign('group_chat_id')->references('id')->on('group_chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['group_chat_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_chat_users');
    }
};
