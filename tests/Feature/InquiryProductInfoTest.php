<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Conversation;
use App\Models\Inquiry;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InquiryProductInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that product information is automatically sent when inquiry is created.
     *
     * @return void
     */
    public function test_product_info_message_sent_when_inquiry_created()
    {
        // Create users
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        // Create a product
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'name' => 'Test Product',
            'price' => 99.99,
            'moq' => 10,
            'unit' => 'piece',
            'origin_country' => 'China',
            'description' => 'This is a test product description'
        ]);
        
        // Authenticate as buyer
        $this->actingAs($buyer);
        
        // Make POST request to add product to inquiries
        $response = $this->postJson('/inquiries/add', [
            'product_id' => $product->id,
        ]);
        
        // Assert the response
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Product added to inquiries successfully.',
                 ]);
        
        // Assert that the inquiry was created in the database
        $this->assertDatabaseHas('inquiries', [
            'product_id' => $product->id,
        ]);
        
        // Assert that a conversation was created
        $this->assertDatabaseHas('conversations', [
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
        ]);
        
        // Get the conversation
        $conversation = Conversation::where('buyer_id', $buyer->id)
            ->where('seller_id', $seller->id)
            ->first();
        
        // Assert that a product info message was created
        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $buyer->id,
            'message_type' => 'text',
        ]);
        
        // Get the message
        $message = Message::where('conversation_id', $conversation->id)
            ->where('sender_id', $buyer->id)
            ->first();
        
        // Assert that the message contains product information
        $this->assertStringContainsString('[Product: Test Product]', $message->message_text);
        $this->assertStringContainsString('Price: ₹99.99', $message->message_text);
        $this->assertStringContainsString('MOQ: 10 piece', $message->message_text);
        $this->assertStringContainsString('Origin: China', $message->message_text);
        $this->assertStringContainsString('This is a test product description', $message->message_text);
    }
}