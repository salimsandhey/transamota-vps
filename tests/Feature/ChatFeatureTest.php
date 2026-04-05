<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class ChatFeatureTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_buyer_can_start_a_conversation_with_a_seller()
    {
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        $response = $this->actingAs($buyer)->post(route('chat.create-conversation'), [
            'seller_id' => $seller->id
        ]);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('conversations', [
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id
        ]);
    }
    
    /** @test */
    public function a_user_can_send_a_message_in_a_conversation()
    {
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        $conversation = Conversation::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id
        ]);
        
        $response = $this->actingAs($buyer)->post(route('chat.send-message'), [
            'conversation_id' => $conversation->id,
            'message' => 'Hello, I am interested in your product.'
        ]);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $buyer->id,
            'message_text' => 'Hello, I am interested in your product.'
        ]);
    }
}
