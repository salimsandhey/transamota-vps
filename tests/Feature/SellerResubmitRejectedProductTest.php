<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;

class SellerResubmitRejectedProductTest extends TestCase
{
    use RefreshDatabase;

    protected $seller;
    protected $admin;
    protected $category;
    protected $subcategory;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a seller user
        $this->seller = User::factory()->create([
            'role' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create a verified seller profile
        $this->seller->profile()->create([
            'verification_doc' => 'verification_doc.jpg',
            'verified_by_admin' => true,
        ]);

        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create category and subcategory
        $this->category = Category::factory()->create();
        $this->subcategory = Subcategory::factory()->create([
            'category_id' => $this->category->id
        ]);
    }

    /** @test */
    public function seller_cannot_edit_rejected_product()
    {
        // Create a rejected product
        $product = Product::factory()->create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'verification_status' => 'rejected',
            'rejection_reason' => 'Product does not meet quality standards',
        ]);

        // Seller cannot access edit page for rejected product
        $response = $this->actingAs($this->seller)
                         ->get(route('seller.products.edit', $product->id));

        $response->assertRedirect(route('seller.products'));
        $response->assertSessionHas('error', 'This product is not yet approved and cannot be edited. Please wait for admin approval.');
    }

    /** @test */
    public function seller_cannot_update_rejected_product()
    {
        // Create a rejected product
        $product = Product::factory()->create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'name' => 'Original Product Name',
            'verification_status' => 'rejected',
            'rejection_reason' => 'Product does not meet quality standards',
        ]);

        // Seller tries to update the rejected product
        $response = $this->actingAs($this->seller)
                         ->put(route('seller.products.update', $product->id), [
                             'name' => 'Updated Product Name',
                             'category_id' => $this->category->id,
                             'subcategory_id' => $this->subcategory->id,
                             'description' => 'Updated product description',
                             'price' => 99.99,
                             'moq' => 1,
                             'unit' => 'piece',
                             'origin_country' => 'USA',
                             'status' => 'inactive',
                         ]);

        $response->assertRedirect(route('seller.products'));
        $response->assertSessionHas('error', 'This product is not yet approved and cannot be updated. Please wait for admin approval.');

        // Refresh the product from database
        $product->refresh();

        // Verify product details were NOT updated
        $this->assertNotEquals('Updated Product Name', $product->name);
        $this->assertEquals('rejected', $product->verification_status);
        $this->assertEquals('Product does not meet quality standards', $product->rejection_reason);
    }

    /** @test */
    public function seller_can_edit_approved_product()
    {
        // Create an approved product
        $product = Product::factory()->create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'verification_status' => 'approved',
        ]);

        // Seller can access edit page for approved product
        $response = $this->actingAs($this->seller)
                         ->get(route('seller.products.edit', $product->id));

        $response->assertStatus(200);
        $response->assertSee('Editing Approved Product');
        $response->assertSee('After making your changes, this product will be sent back for admin verification.');
    }

    /** @test */
    public function edit_button_does_not_show_for_rejected_products_in_index()
    {
        // Create a rejected product
        $product = Product::factory()->create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'verification_status' => 'rejected',
        ]);

        // Seller visits product index
        $response = $this->actingAs($this->seller)
                         ->get(route('seller.products'));

        $response->assertStatus(200);
        $response->assertDontSee('Edit & Resubmit');
    }

    /** @test */
    public function edit_button_does_not_show_for_rejected_products_in_show_view()
    {
        // Create a rejected product
        $product = Product::factory()->create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'verification_status' => 'rejected',
        ]);

        // Seller visits product details page
        $response = $this->actingAs($this->seller)
                         ->get(route('seller.products.show', $product->id));

        $response->assertStatus(200);
        $response->assertDontSee('Edit & Resubmit');
    }

    /** @test */
    public function seller_can_update_approved_product_and_it_goes_back_to_pending()
    {
        // Create an approved product
        $product = Product::factory()->create([
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'name' => 'Approved Product Name',
            'verification_status' => 'approved',
        ]);

        // Seller updates the approved product
        $response = $this->actingAs($this->seller)
                         ->put(route('seller.products.update', $product->id), [
                             'name' => 'Updated Product Name',
                             'category_id' => $this->category->id,
                             'subcategory_id' => $this->subcategory->id,
                             'description' => 'Updated product description',
                             'price' => 99.99,
                             'moq' => 1,
                             'unit' => 'piece',
                             'origin_country' => 'USA',
                             'status' => 'inactive',
                         ]);

        $response->assertRedirect(route('seller.products'));
        $response->assertSessionHas('success', 'Product updated and sent back for admin verification.');

        // Refresh the product from database
        $product->refresh();

        // Verify product details were updated
        $this->assertEquals('Updated Product Name', $product->name);
        $this->assertEquals('pending', $product->verification_status);
        $this->assertNull($product->rejection_reason);
    }
}