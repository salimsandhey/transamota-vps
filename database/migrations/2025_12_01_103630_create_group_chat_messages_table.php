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
        Schema::create('group_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_chat_id');
            $table->unsignedBigInteger('sender_id');
            $table->string('message_type')->default('text'); // text, image, file
            $table->longText('message_text')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamps();
            
            $table->foreign('group_chat_id')->references('id')->on('group_chats')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index('group_chat_id');
            $table->index('sender_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_chat_messages');
    }
};
