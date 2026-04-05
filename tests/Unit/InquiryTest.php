<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Conversation;
use App\Models\Inquiry;

class InquiryTest extends TestCase
{
    /**
     * Test that an inquiry can be created successfully.
     *
     * @return void
     */
    public function test_inquiry_can_be_created()
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
        
        // Create an inquiry
        $inquiry = Inquiry::create([
            'conversation_id' => $conversation->id,
            'product_id' => $product->id,
            'added_at' => now(),
        ]);
        
        // Assert that the inquiry was created successfully
        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'conversation_id' => $conversation->id,
            'product_id' => $product->id,
        ]);
    }
}