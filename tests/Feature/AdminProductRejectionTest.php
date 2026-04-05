<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class AdminProductRejectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_reject_product_with_reason()
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
        $response = $this->patch(route('admin.products.reject', $product), [
            'rejection_reason' => 'Product does not meet quality standards'
        ]);
        
        // Assert redirect back
        $response->assertRedirect();
        
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
    public function admin_cannot_reject_product_without_reason()
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
        $response = $this->patch(route('admin.products.reject', $product), [
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
}