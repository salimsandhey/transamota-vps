<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Conversation;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InquiryFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a buyer can add a product to inquiries.
     *
     * @return void
     */
    public function test_buyer_can_add_product_to_inquiries()
    {
        // Create users
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        // Create a product
        $product = Product::factory()->create(['seller_id' => $seller->id]);
        
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
    }
    
    /**
     * Test that a buyer can view their inquiries.
     *
     * @return void
     */
    public function test_buyer_can_view_inquiries()
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
        
        // Create an inquiry using the factory correctly
        $inquiry = Inquiry::factory()->create([
            'conversation_id' => $conversation->id,
            'product_id' => $product->id,
        ]);
        
        // Authenticate as buyer
        $this->actingAs($buyer);
        
        // Make GET request to view inquiries
        $response = $this->get('/inquiries');
        
        // Assert the response
        $response->assertStatus(200);
    }
}