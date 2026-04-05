<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function seller_can_update_product_with_new_images()
    {
        // Create a seller user
        $seller = User::factory()->create(['role' => 'seller']);
        
        // Create a category
        $category = Category::factory()->create();
        
        // Create a product for the seller
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'verification_status' => 'approved'
        ]);
        
        // Authenticate as the seller
        $this->actingAs($seller);
        
        // Create a fake image
        Storage::fake('public');
        $image = UploadedFile::fake()->image('test-image.jpg');
        
        // Submit the form with new image
        $response = $this->put(route('seller.products.update', $product->id), [
            'name' => 'Updated Product Name',
            'category_id' => $category->id,
            'description' => 'Updated product description',
            'price' => 99.99,
            'moq' => 1,
            'unit' => 'piece',
            'origin_country' => 'USA',
            'status' => 'active',
            'images' => [$image]
        ]);
        
        // Assert redirect back to products page
        $response->assertRedirect(route('seller.products'));
        
        // Assert success message
        $response->assertSessionHas('success', 'Product updated and sent back for admin verification.');
        
        // Assert the product was updated
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name'
        ]);
        
        // Assert the image was saved
        Storage::disk('public')->assertExists('products/test-image.jpg');
    }
    
    /** @test */
    public function seller_can_delete_product_images()
    {
        // Create a seller user
        $seller = User::factory()->create(['role' => 'seller']);
        
        // Create a category
        $category = Category::factory()->create();
        
        // Create a product for the seller
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'verification_status' => 'approved'
        ]);
        
        // Create a product image
        $productImage = ProductImage::factory()->create([
            'product_id' => $product->id
        ]);
        
        // Authenticate as the seller
        $this->actingAs($seller);
        
        // Submit the form with delete image request
        $response = $this->put(route('seller.products.update', $product->id), [
            'name' => 'Updated Product Name',
            'category_id' => $category->id,
            'description' => 'Updated product description',
            'price' => 99.99,
            'moq' => 1,
            'unit' => 'piece',
            'origin_country' => 'USA',
            'status' => 'active',
            'delete_images' => $productImage->id
        ]);
        
        // Assert redirect back to products page
        $response->assertRedirect(route('seller.products'));
        
        // Assert success message
        $response->assertSessionHas('success', 'Product updated and sent back for admin verification.');
        
        // Assert the image was deleted
        $this->assertDatabaseMissing('product_images', [
            'id' => $productImage->id
        ]);
    }
}