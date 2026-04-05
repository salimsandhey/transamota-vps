<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class AdminVerificationRejectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_reject_product_with_reason_in_verification_section()
    {
        // Create an admin user
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Create a category
        $category = Category::factory()->create();
        
        // Create a product with pending verification
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'verification_status' => 'pending'
        ]);
        
        // Authenticate as the admin
        $this->actingAs($admin);
        
        // Submit the rejection with a reason
        $response = $this->patch(route('admin.verifications.products.reject', $product), [
            'rejection_reason' => 'Product does not meet quality standards'
        ]);
        
        // Assert redirect back to verification index
        $response->assertRedirect(route('admin.verifications.products.index'));
        
        // Assert success message
        $response->assertSessionHas('success');
        
        // Assert the product was rejected with the reason
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'verification_status' => 'rejected',
            'rejection_reason' => 'Product does not meet quality standards'
        ]);
    }
    
    /** @test */
    public function admin_cannot_reject_product_without_reason_in_verification_section()
    {
        // Create an admin user
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Create a category
        $category = Category::factory()->create();
        
        // Create a product with pending verification
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'verification_status' => 'pending'
        ]);
        
        // Authenticate as the admin
        $this->actingAs($admin);
        
        // Submit the rejection without a reason
        $response = $this->patch(route('admin.verifications.products.reject', $product), [
            'rejection_reason' => ''
        ]);
        
        // Assert validation error
        $response->assertSessionHasErrors('rejection_reason');
        
        // Assert the product status is unchanged
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'verification_status' => 'pending',
            'rejection_reason' => null
        ]);
    }
    
    /** @test */
    public function rejection_reason_is_displayed_in_product_verification_details()
    {
        // Create an admin user
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Create a category
        $category = Category::factory()->create();
        
        // Create a rejected product with a reason
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'verification_status' => 'rejected',
            'rejection_reason' => 'Product does not meet quality standards'
        ]);
        
        // Authenticate as the admin
        $this->actingAs($admin);
        
        // Visit the product verification details page
        $response = $this->get(route('admin.verifications.products.show', $product));
        
        // Assert the rejection reason is displayed
        $response->assertSee('Rejection Reason');
        $response->assertSee('Product does not meet quality standards');
    }
}