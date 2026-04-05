<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class SellerProductRejectionReasonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function seller_can_see_rejection_reason_on_product_details_page()
    {
        // Create a seller user
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        // Create a user profile for the seller with verified documents
        $seller->profile()->create([
            'verification_doc' => 'documents/test.pdf',
            'verified_by_admin' => true
        ]);
        
        // Create a category
        $category = Category::factory()->create();
        
        // Create a rejected product with a reason
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'verification_status' => 'rejected',
            'rejection_reason' => 'Product does not meet quality standards'
        ]);
        
        // Authenticate as the seller
        $this->actingAs($seller);
        
        // Visit the product details page
        $response = $this->get(route('seller.products.show', $product));
        
        // Assert the rejection reason is displayed
        $response->assertSee('Rejection Reason');
        $response->assertSee('Product does not meet quality standards');
    }
    
    /** @test */
    public function seller_can_see_rejection_indicator_on_product_list_page()
    {
        // Create a seller user
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        // Create a user profile for the seller with verified documents
        $seller->profile()->create([
            'verification_doc' => 'documents/test.pdf',
            'verified_by_admin' => true
        ]);
        
        // Create a category
        $category = Category::factory()->create();
        
        // Create a rejected product with a reason
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'verification_status' => 'rejected',
            'rejection_reason' => 'Product does not meet quality standards'
        ]);
        
        // Authenticate as the seller
        $this->actingAs($seller);
        
        // Visit the product list page
        $response = $this->get(route('seller.products'));
        
        // Assert the rejection indicator is displayed
        $response->assertSee('Reason provided');
        $response->assertSeeInOrder(['Verification: Rejected', 'Reason provided']);
    }
    
    /** @test */
    public function seller_does_not_see_rejection_reason_when_product_is_not_rejected()
    {
        // Create a seller user
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        
        // Create a user profile for the seller with verified documents
        $seller->profile()->create([
            'verification_doc' => 'documents/test.pdf',
            'verified_by_admin' => true
        ]);
        
        // Create a category
        $category = Category::factory()->create();
        
        // Create an approved product
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'verification_status' => 'approved'
        ]);
        
        // Authenticate as the seller
        $this->actingAs($seller);
        
        // Visit the product details page
        $response = $this->get(route('seller.products.show', $product));
        
        // Assert the rejection reason is not displayed
        $response->assertDontSee('Rejection Reason');
    }
}