<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Conversation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnhancedChatTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test that a conversation can be created with product reference.
     *
     * @return void
     */
    public function test_conversation_can_be_created_with_product_reference()
    {
        // Create users
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        // Create a product
        $product = Product::factory()->create(['seller_id' => $seller->id]);
        
        // Authenticate as buyer
        $this->actingAs($buyer);
        
        // Make POST request to create conversation with product reference
        $response = $this->postJson('/chat/conversation', [
            'seller_id' => $seller->id,
            'product_id' => $product->id,
        ]);
        
        // Assert the response
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'conversation_id',
                     'redirect_url'
                 ]);
    }
    
    /**
     * Test that a message can be sent with product reference.
     *
     * @return void
     */
    public function test_message_can_be_sent_with_product_reference()
    {
        // Create users
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        // Create a product
        $product = Product::factory()->create(['seller_id' => $seller->id]);
        
        // Create a conversation
        $conversation = Conversation::factory()->create([
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
        ]);
        
        // Authenticate as buyer
        $this->actingAs($buyer);
        
        // Make POST request to send message with product reference
        $response = $this->postJson('/chat/message', [
            'conversation_id' => $conversation->id,
            'message' => 'I am interested in this product',
            'product_id' => $product->id,
        ]);
        
        // Assert the response
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message' => [
                         'id',
                         'message_text',
                         'sender_id',
                         'conversation_id'
                     ]
                 ]);
        
        // Assert that the message includes product reference
        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'message_text' => "[Product: {$product->name}] I am interested in this product",
        ]);
    }
}